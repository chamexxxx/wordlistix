<?php

namespace App\Controller;

use App\Entity\Comparison;
use App\Entity\Dictionary;
use App\Entity\Word;
use App\Repository\DictionaryRepository;
use App\Service\ZipFileExtractor;
use App\Utils\CsvReader;
use App\Utils\Zip;
use App\Validator\Constraints\DictionaryCsvHeader;
use App\Validator\Constraints\DictionaryRequirements;
use App\Serializer\ViolationSerializer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use ZipArchive;

class DictionaryController extends AbstractController
{
    public function index(DictionaryRepository $repository): JsonResponse
    {
        $dictionaries = $repository->findAll();

        return $this->json($dictionaries, Response::HTTP_OK, [], [
            AbstractNormalizer::IGNORED_ATTRIBUTES => ['comparisons']
        ]);
    }

    public function create(
        Request $request,
        ValidatorInterface $validator,
        ManagerRegistry $doctrine,
        SluggerInterface $slugger,
        ZipFileExtractor $zipFileExtractor
    ): JsonResponse
    {
        $requestData = array_merge(
            $request->request->all(),
            $request->files->all()
        );

        $errors = $validator->validate($requestData, new DictionaryRequirements());

        if ($errors->count() > 0) {
            return $this->json(
                ViolationSerializer::convertToArrayWithPropertyAccessor($errors),
                Response::HTTP_BAD_REQUEST
            );
        }

        $path = $request->files->get('dictionary')->getRealPath();

        $entityManager = $doctrine->getManager();

        $dictionary = new Dictionary();
        $dictionary->setName($request->get('name'));

        $errors = $validator->validate($dictionary);

        if ($errors->count() > 0) {
            return $this->json(
                ViolationSerializer::convertToArray($errors),
                Response::HTTP_BAD_REQUEST
            );
        }

        $entityManager->persist($dictionary);

        $csv = new CsvReader($path, ';');

        $zip = new ZipArchive();
        $header = $csv->getHeader();

        $errors = $validator->validate($header, new DictionaryCsvHeader());

        if ($errors->count() > 0) {
            $errorsString = $errors->get(0)->getMessage();

            return $this->json([
                'dictionary' => [$errorsString]
            ], Response::HTTP_BAD_REQUEST);
        }

        $imagesExists = false;

        if (array_key_exists(2, $header) && strtolower($header[2]) === 'image' && $request->files->has('images')) {
            $path = $request->files->get('images')->getRealPath();

            $zipStatus = $zip->open($path);

            if ($zipStatus === true) {
                $imagesExists = true;
            } else {
                return $this->json(Zip::statusString($zipStatus));
            }
        }

        foreach ($csv as $row) {
            $comparison = new Comparison();
            $comparison->setDictionary($dictionary);

            $words = array_slice($row, 0, 2, true);

            foreach ($words as $languageCode => $text) {
                $word = new Word();

                $word->setComparison($comparison)
                    ->setLanguageCode($languageCode)
                    ->setText($text);

                $entityManager->persist($word);
            }

            if ($imagesExists && isset($row['Image']) && $newFilename = $zipFileExtractor->extract($row['Image'], $zip)) {
                $comparison->setImage($newFilename);
            }

            $dictionary->getComparisons()->add($comparison);

            $entityManager->persist($comparison);
        }

        if ($dictionary->getComparisons()->count() === 0) {
            return $this->json([
                'dictionary' => ['???????????????????? ???????? ?????????? ????????']
            ], Response::HTTP_BAD_REQUEST);
        }

        $entityManager->flush();

        return $this->json([
            'id' => $dictionary->getId(),
            'name' => $dictionary->getName(),
            'count' => $dictionary->getComparisons()->count()
        ]);
    }

    public function show(DictionaryRepository $repository, int $id): JsonResponse
    {
        $dictionary = $repository->find($id);

        if (!$dictionary) {
            throw $this->createNotFoundException('?????????????? ?? ?????????? id ???? ????????????????????');
        }

        return $this->json($dictionary, Response::HTTP_OK, [], [
            AbstractNormalizer::IGNORED_ATTRIBUTES => ['dictionary', 'comparison']
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Comparison;
use App\Repository\ComparisonRepository;
use App\Repository\WordRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class ComparisonController extends AbstractController
{
    /**
     * @Route("/comparison", name="app_comparison")
     */
    public function index(ComparisonRepository $repository): Response
    {
        $comparisons = $repository->findAll();

        return $this->json($comparisons, Response::HTTP_OK, [], [
            AbstractNormalizer::ATTRIBUTES => [
                'id',
                'image',
                'dictionary' => ['id', 'name'],
                'words' => ['languageCode', 'text']
            ]
        ]);
    }
}

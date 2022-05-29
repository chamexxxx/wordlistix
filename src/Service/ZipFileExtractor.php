<?php

namespace App\Service;

use Symfony\Component\String\Slugger\SluggerInterface;
use ZipArchive;

class ZipFileExtractor
{
    private $targetDirectory;
    private $slugger;

    public function __construct(string $targetDirectory, SluggerInterface $slugger)
    {
        $this->targetDirectory = $targetDirectory;
        $this->slugger = $slugger;
    }

    public function extract(string $path, ZipArchive $zip)
    {
        [
            'filename' => $filename,
            'extension' => $extension,
        ] = pathinfo($path);

        $safeFilename = $this->slugger->slug($filename);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$extension;

        if ($zip->renameName($path, $newFilename) && $zip->extractTo($this->targetDirectory, $newFilename)) {
            return $newFilename;
        } else {
            return false;
        }
    }

    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }
}

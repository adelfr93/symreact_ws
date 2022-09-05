<?php

namespace App\Sercive;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
//use Symfony\Component\String\Slugger\SluggerInterface;

class UploaderHelper{

    private $uploadsPath;

    public function __construct(string $uploadsPath/* , SluggerInterface $slugger */)
    {
        $this->uploadsPath = $uploadsPath;
        //$this->slugger = $slugger;

    }

    public function UploadProductImage(UploadedFile $photoFile) : string
    {
        $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                //$safeFilename = $this->slugger->slug($originalFilename);
                $safeFilename = $originalFilename;
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photoFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $photoFile->move(
                        $this->uploadsPath.'/products',
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                return $newFilename;
                
    }
}
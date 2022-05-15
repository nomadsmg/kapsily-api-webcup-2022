<?php

namespace App\Manager\Media;

use App\Entity\Media\Media;
use App\Service\Assets\FileUploader;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MediaManager
{
    public function __construct(private FileUploader $fileUploader, private ParameterBagInterface $parameterBag)
    {
    }

    public function uploadMedia(UploadedFile $uploadedFile, string $relativeDir, ?string $filename = null): Media
    {
        $media = new Media();

        $media->setFilename($filename !== null ? $filename : $uploadedFile->getClientOriginalName());
        $media->filePath = $this->fileUploader->upload($relativeDir, $uploadedFile);
        $media->url = $this->parameterBag->get('asset.base_url') . $media->filePath;

        return $media;
    }
}

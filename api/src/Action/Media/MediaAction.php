<?php

namespace App\Action\Media;

use App\Manager\Media\MediaManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class MediaAction extends AbstractController
{
    public function __invoke(Request $request, MediaManager $mediaManager)
    {
        $uploadedFile = $request->files->get('file');
        $relativeDir = $request->request->get('path');
        $filename = $request->request->get('filename');

        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }

        if (!$relativeDir) {
            throw new BadRequestHttpException('"path" is required');
        }

        return $mediaManager->uploadMedia($uploadedFile, $relativeDir, $filename);
    }
}

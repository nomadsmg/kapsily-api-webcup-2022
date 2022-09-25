<?php

namespace App\Service\Assets;

use League\Flysystem\FilesystemException;
use League\Flysystem\FilesystemOperator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    public function __construct(private FilesystemOperator $defaultStorage, private FileManipulator $fileManipulator)
    {
        $this->storage = $defaultStorage;
        $this->fileManipulator = $fileManipulator;
    }

    /**
     * @throws FilesystemException
     */
    public function upload(string $targetDirectory, UploadedFile $file): string
    {
        $uploadedFileName = $this->fileManipulator->hashFile($file->getPathname()) . '.' . $file->getClientOriginalExtension();
        $uploadPath = sprintf('/%s/%s', $targetDirectory, $uploadedFileName);
        $this->storage->writeStream($uploadPath, fopen($file->getPathname(), 'rb'));

        return $uploadPath;
    }

    /**
     * @throws FilesystemException
     */
    public function unlink(string $path)
    {
        if ($this->storage->fileExists($path)) {
            $this->storage->delete($path);
        }
    }
}

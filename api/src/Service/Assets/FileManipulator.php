<?php

namespace App\Service\Assets;

use Exception;

class FileManipulator
{
    /**
     * @return false|string
     *
     * @throws Exception
     */
    public function hashFile(string $path)
    {
        if (file_exists($path)) {
            $hash = sha1_file($path);
            if (!$hash) {
                throw new Exception('Cannot get hash from uploaded file');
            }

            return $hash;
        }

        throw new Exception(sprintf('File %s not found', $path));
    }
}

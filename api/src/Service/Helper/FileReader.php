<?php

namespace App\Service\Helper;

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;

class FileReader
{
    private ParameterBagInterface $parameterBag;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
    }

    public function loadRightInitFile()
    {
        $fullPath = $this->parameterBag->get('setup.file.security.rights');
        if (!$this->fileExist($fullPath)) {
            return [];
        }
        $data = [];
        $reader = new Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($fullPath);
        foreach ($spreadsheet as $index => $row) {
            if (0 === $index) {
                continue;
            }
            $data[] = ['key' => $row[3], 'label_fr' => $row[4]];
        }

        return $data;
    }

    public static function fileExist(string $fullPath)
    {
        return (new Filesystem())->exists($fullPath);
    }
}

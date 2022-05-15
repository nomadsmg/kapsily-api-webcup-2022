<?php


namespace App\Service\Helper;


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelDumper
{
    public function export(array $data, string $filename, string $title)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle($title);
        $sheet->fromArray($data, null, 'A1', true);
        $writer = new Xlsx($spreadsheet);
        // Create a Temporary file in the system

        $tempfile = tempnam(sys_get_temp_dir(), $filename);

        // Create the excel file in the tmp directory of the system
        $writer->save($tempfile);

        return $tempfile;
    }
}
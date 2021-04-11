<?php

namespace App\Services\Helper\FileSupport;

class Csv implements FileInterface
{
    public function saveToFile(string $fileName, array $data)
    {
        $fp = fopen($fileName, 'w');
        foreach ($data as $datum) {
            fputcsv($fp, $datum);
        }
        fclose($fp);
    }
}

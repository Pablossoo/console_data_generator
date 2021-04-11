<?php

namespace App\Services\Helper\FileSupport;

interface FileInterface
{
    public function saveToFile(string $fileName, array $data);
}

<?php

namespace App\Factory;

use App\Dictionary\FileExtension;
use App\Services\Helper\FileSupport\Csv;
use App\Services\Helper\FileSupport\FileInterface;
use App\Services\Helper\FileSupport\Json;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

final class FileFactory
{
    public function createFile(string $fileExtension): FileInterface
    {
        switch ($fileExtension) {
            case FileExtension::CSV:
                return new Csv();
            case FileExtension::JSON:
                return new Json();
            default:
                throw new FileException(sprintf('unsupported type %s', $fileExtension));
        }
    }
}

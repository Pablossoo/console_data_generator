<?php

namespace App\Services\Helper;

class ExtractorNumbersFromString
{
    public function extract(string $string): array
    {
        $numbers = [];

        $arrayCharacters = str_split($string);

        foreach ($arrayCharacters as $character) {
            if (is_numeric($character)) {
                $numbers[] = $character;
            }
        }

        return $numbers;
    }
}

<?php

namespace App\Services;

interface GenerateRandomCharactersInterface
{
    public function generate(int $countSets): array;

    public function getSetName(): string;
}

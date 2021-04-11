<?php

namespace App\Services;

use Symfony\Component\String\ByteString;

final class GenerateRandomString implements GenerateRandomCharactersInterface
{
    private const MIN_LENGTH = 2;
    private const MAX_LENGTH = 100;

    public function generate(int $countSets): array
    {
        $randomCharacters = [];

        for ($i = 0; $i < $countSets; $i++) {
            //fromRandom uses the [a-zA-Z0-9] pattern by default, if you want to use a different pattern, you can pass the second parameter
            //@doc https://symfony.com/doc/current/components/string.html
            $randomCharacters[] = ByteString::fromRandom(rand(GenerateRandomString::MIN_LENGTH, GenerateRandomString::MAX_LENGTH))->toString();
        }

        return $randomCharacters;
    }

    public function getSetName(): string
    {
        return 'setB';
    }
}

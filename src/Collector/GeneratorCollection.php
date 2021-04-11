<?php

namespace App\Collector;

use App\Services\GenerateRandomCharactersInterface;
use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\VarDumper\VarDumper;

final class GeneratorCollection
{
    private iterable $generators;

    public function __construct(iterable $generators)
    {
        $this->generators = $generators;
    }

    public function getCollection(): array
    {
        return iterator_to_array($this->generators);
    }
}

<?php

namespace App\Validator\Rules;

interface ComparatorInterface
{
    public function compare(int $valueA, string $valueB): int;

    public function getName(): string;
}

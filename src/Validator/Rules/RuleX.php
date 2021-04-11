<?php

namespace App\Validator\Rules;

class RuleX implements ComparatorInterface
{
    public function compare(int $valueA, string $valueB): int
    {
        if (strlen($valueB) > $valueA) {
            return 2;
        }
        return 1;
    }

    public function getName(): string
    {
        return 'RuleX';
    }
}

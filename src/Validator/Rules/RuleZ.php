<?php

namespace App\Validator\Rules;

final class RuleZ implements ComparatorInterface
{
    public function compare(int $valueA, string $valueB): int
    {
        if ($valueA < 15) {
            return 3;
        } elseif ($valueA > 37) {
            return 7;
        }
        // value 0 because in the requirements was not default value
        return 0;
    }

    public function getName(): string
    {
        return 'RuleZ';
    }
}

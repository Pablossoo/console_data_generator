<?php

namespace App\Validator\Rules;

use App\Services\Helper\ExtractorNumbersFromString;

final class RuleY implements ComparatorInterface
{
    private ExtractorNumbersFromString $extractorNumbersFromString;

    public function __construct(ExtractorNumbersFromString $extractorNumbersFromString)
    {
        $this->extractorNumbersFromString = $extractorNumbersFromString;
    }

    public function compare(int $valueA, string $valueB): int
    {
        if (count($this->extractorNumbersFromString->extract($valueB)) > $valueA) {
            return 1;
        }
        return 2;
    }
    public function getName(): string
    {
        return 'RuleY';
    }
}

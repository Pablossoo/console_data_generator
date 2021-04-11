<?php

namespace App\Tests\Validator\Rules;

use App\Services\Helper\ExtractorNumbersFromString;
use App\Validator\Rules\RuleY;
use PHPUnit\Framework\TestCase;

class TestRuleY extends TestCase
{
    /**
     * @dataProvider provider
     */
    public function testIfLengthFromSetBIsGreaterOrLessThanValueFromSetA(int $valueA, string $valueB, int $expected)
    {
        $rule = new RuleY(new ExtractorNumbersFromString());

        $result = $rule->compare($valueA, $valueB);
        $this->assertEquals($expected, $result);
    }

    public function provider(): array
    {
        return
            [
                [3, '3dsf324234', 1],
                [44, '3tryryrty', 2]
            ];
    }
}

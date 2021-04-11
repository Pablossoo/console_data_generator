<?php

namespace App\Tests\Validator\Rules;

use App\Validator\Rules\RuleX;
use PHPUnit\Framework\TestCase;

class TestRuleX extends TestCase
{
    /**
     * @dataProvider provider
     */
    public function testIfLengthStringFromSetBIsGreaterOrLessThanValueNumberFromSetA(int $valueA, string $valueB, int $expected)
    {
        $rule = new RuleX();

        $result = $rule->compare($valueA, $valueB);
        $this->assertEquals($expected, $result);
    }

    public function provider(): array
    {
        return
            [
                [55, '3dsf324234', 1],
                [3, '3dsf324234', 2]
            ];
    }
}

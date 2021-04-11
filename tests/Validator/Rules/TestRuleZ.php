<?php

namespace App\Tests\Validator\Rules;

use App\Validator\Rules\RuleZ;
use PHPUnit\Framework\TestCase;

class TestRuleZ extends TestCase
{
    /**
     * @dataProvider provider
     */
    public function testIfValueFromSetAIsGreaterOrLessThan37(int $valueA, int $valueB, int $expected)
    {
        $rule = new RuleZ();

        $result = $rule->compare($valueA, $valueB);
        $this->assertEquals($expected, $result);
    }

    public function provider(): array
    {
        return
            [
                [55, 37, 7],
                [3, 15, 3],
                [25, 18 , 0]
            ];
    }
}

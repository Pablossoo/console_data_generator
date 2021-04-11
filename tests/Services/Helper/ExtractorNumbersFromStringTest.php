<?php

namespace App\Tests\Services\Helper;

use App\Services\Helper\ExtractorNumbersFromString;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ExtractorNumbersFromStringTest extends WebTestCase
{
    /**
     * @dataProvider provider
     */
    public function testIfNumbersAreExtractFromString($string, $expected)
    {
        $extractor = new ExtractorNumbersFromString();

        $result = $extractor->extract($string);
        $this->assertIsArray($result);
        $this->assertEqualsCanonicalizing($expected,$result);
    }

    public function provider(): array
    {
        return [
            ['ewrw234',[2,3,4]],
            ['1rr4', [1,4]],
            ['dsd4', [4]],
            ['fertretret111sss322', [1,1,1,3,2,2]]
        ];
    }
}
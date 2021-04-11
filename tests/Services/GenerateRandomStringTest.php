<?php

namespace App\Tests\Services;

use App\Services\FetchRandomNumberFromApi;
use App\Services\GenerateRandomString;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GenerateRandomStringTest extends TestCase
{
    private GenerateRandomString $generateRandomString;

    protected function setUp(): void
    {
        $this->generateRandomString = new GenerateRandomString();
    }

    public function testGenerateRandomString()
    {
        $result = $this->generateRandomString->generate(10);

        $this->assertIsArray($result);
        $this->assertCount(10, $result);
        $this->assertRegExp('/[a-zA-Z0-9]/', $result[0]);

    }

    public function testReturnSetsName()
    {
        $name = $this->generateRandomString->getSetName();

        $this->assertEquals('setB', $name);
    }
}

<?php

namespace App\Tests\Services;

use App\Services\FetchRandomNumberFromApi;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class FetchRandomNumberFromApiTest extends TestCase
{

    public function testFetchDataFromApi()
    {
        $loggerInterfaceLogg = $this->createMock(LoggerInterface::class);

        $responses = [
            new MockResponse((json_encode([1, 2, 3, 4, 5, 5, 3, 33, 4, 22, 76])), ['min' => 0, 'max' => 80, 'count' => 11]),
        ];
        $httpClientMock = new MockHttpClient($responses);

        $this->fetchRandomNumberService = new FetchRandomNumberFromApi($httpClientMock, $loggerInterfaceLogg);
        $result = $this->fetchRandomNumberService->generate(11);
        $this->assertIsArray($result);
    }

    public function testChooseStrategyFromCountSetsArgument()
    {
        $loggerInterfaceLogg = $this->createMock(LoggerInterface::class);

        $httpClientMock = new MockHttpClient(new MockResponse());

        $fetchRandomNumberService = new FetchRandomNumberFromApi($httpClientMock, $loggerInterfaceLogg);
        $result = $fetchRandomNumberService->generate(110);
        $this->assertIsArray($result);
    }

    public function testReturnEmptyArrayIfHttpStatusIsNot200()
    {
        $loggerInterfaceLogg = $this->createMock(LoggerInterface::class);

        $httpClientMock = new MockHttpClient(new MockResponse('', ['http_code' => 500]));

        $fetchRandomNumberService = new FetchRandomNumberFromApi($httpClientMock, $loggerInterfaceLogg);
        $result = $fetchRandomNumberService->generate(110);
        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    public function testReturnSetsName()
    {
        $loggerInterfaceLogg = $this->createMock(LoggerInterface::class);

        $httpClientMock = new MockHttpClient(new MockResponse());

        $fetchRandomNumberService = new FetchRandomNumberFromApi($httpClientMock, $loggerInterfaceLogg);
        $name = $fetchRandomNumberService->getSetName();

        $this->assertEquals('setA', $name);
    }
}

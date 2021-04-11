<?php

namespace App\Services;

use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class FetchRandomNumberFromApi implements GenerateRandomCharactersInterface
{
    private HttpClientInterface $client;

    private LoggerInterface $logger;

    private const MAX_COUNT_NUMBERS_FROM_API = 100;

    public function __construct(HttpClientInterface $client, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->logger = $logger;
    }

    public function generate(int $countSets): array
    {
        $params = [
            'min' => 0,
            'max' => 80,
            'count' => $countSets
        ];

        if ($countSets > FetchRandomNumberFromApi::MAX_COUNT_NUMBERS_FROM_API) {
            $generateNumbers = $this->fetchDataAboveTheMaximumLimitAPI($params);
        } else {
            $generateNumbers = $this->fetchDataFromApi($params);
        }


        return $generateNumbers;
    }
    public function getSetName(): string
    {
        return 'setA';
    }


    private function fetchDataAboveTheMaximumLimitAPI(array $params): array
    {
        $numbers = [];
        $countCallingApi = (int)($params['count'] / 100);
        for ($i = 0; $i <= $countCallingApi; $i++) {
            if ($i === $countCallingApi) {
                $params['count'] = $params['count'] % 100;
            }
            $numbers[] = $this->executeRequest($params);
        }

        return array_merge(...$numbers);
    }

    private function fetchDataFromApi(array $params): array
    {
        return $this->executeRequest($params);
    }

    private function executeRequest(array $params): array
    {
        try {
            $response = $this->client->request(
                'GET',
                sprintf('http://www.randomnumberapi.com/api/v1.0/random?%s', http_build_query($params))
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode === 200) {
                return $response->toArray();
            }
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
        }

        return [];
    }
}

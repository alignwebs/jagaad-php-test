<?php

namespace Alignwebs\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Promise\EachPromise;

class HttpClient
{
    private Client $client;
    private int $timeout = 5; // seconds
    private array $requests = [];

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => $this->timeout,
        ]);
    }

    public static function get(string $url): string|bool
    {
        $http_response = false;
        $request = new Request('GET',  $url);
        $promise = (new self)->client->sendAsync($request)->then(function ($response) use (&$http_response) {
            $http_response = $response->getBody();
        });

        $promise->wait();

        return $http_response;
    }

    public function addRequest(string $method, string $url): void
    {
        $method = strtoupper($method);
        // validate method
        if (!in_array($method, ['GET', 'POST', 'PUT', 'DELETE'])) {
            throw new \Exception('Invalid HTTP method');
        }
        // validate $url as valid url
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \Exception('Invalid URL');
        }

        $this->requests[] = new Request($method, $url);
    }

    public function sendConcurrentRequest(): array
    {
        $requests = (function () {
            foreach ($this->requests as $request) {
                yield $this->client->sendAsync($request);
            }
        })();

        $responses = [];
        $pool = new EachPromise($requests, [
            'concurrency' => 100,
            'fulfilled' => function (Response $response) use (&$responses) {
                // this is delivered each successful response
                $responses[] = (string) $response->getBody();
            },
            'rejected' => function ($reason) use (&$responses) {
                // this is delivered each failed request
                $responses[] = (string) $reason->getResponse();
            },
        ]);

        // Initiate the transfers and create a promise
        $promise = $pool->promise();

        // Force the pool of requests to complete.
        $promise->wait();

        return  $responses;
    }
}

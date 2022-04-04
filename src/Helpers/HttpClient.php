<?php

namespace Alignwebs\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7;

class HttpClient
{
    private Client $client;

    var $timeout = 1; // seconds

    public function __construct()
    {
        $this->client = new Client();
    }

    public static function get(string $url)
    {
        $http_response = false;
        try {
            $request = new Request('GET',  $url);
            $promise = (new self)->client->sendAsync($request)->then(function ($response) use (&$http_response) {
                $http_response = $response->getBody();
            });

            $promise->wait();
        } catch (ClientException $e) {
            $http_response = "asdsa";
        }

        return $http_response;
    }
}

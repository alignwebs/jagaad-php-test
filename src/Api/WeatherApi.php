<?php

namespace Alignwebs\Api;

use Alignwebs\Traits\HttpClient;

class WeatherApi
{
    const API_ENDPOINT_V1 = "http://api.weatherapi.com/v1";

    private $API_KEY;

    function __construct(string $apiKey)
    {
        $this->API_KEY = $apiKey;
    }

    public function getWeatherForecast(float $lat, float $lon, $days = 1): array
    {
        $forecast_data = HttpClient::get(self::API_ENDPOINT_V1 . "/forecast.json?key={$this->API_KEY}&q={$lat},{$lon}&days={$days}");
        $forecast_data = json_decode($forecast_data, true);
        return $forecast_data;
    }
}
<?php

namespace Alignwebs\Api;

class Weather
{
    var $API_ENDPOINT_V1 = "http://api.weatherapi.com/v1";
    private $API_KEY;

    function __construct(string $apiKey)
    {
        $this->API_KEY = $apiKey;
    }

    public function getWeatherForecast(float $lat, float $lon, $days = 1): array
    {
        $forecast = file_get_contents($this->API_ENDPOINT_V1 . "/forecast.json?key={$this->API_KEY}&q={$lat},{$lon}&days={$days}");
        $forecast = json_decode($forecast, true);
        return $forecast;
    }
}

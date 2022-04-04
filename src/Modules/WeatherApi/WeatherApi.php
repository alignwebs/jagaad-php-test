<?php

namespace Alignwebs\Modules\WeatherApi;

use Alignwebs\Helpers\HttpClient;

class WeatherApi
{
    const API_ENDPOINT_V1 = "http://api.weatherapi.com/v1";

    private $API_KEY;

    function __construct(string $apiKey)
    {
        $this->API_KEY = $apiKey;
    }

    public function fetchWeatherForecast(float $lat, float $lon, $days = 1): WeatherForecastDaysCollection
    {
        $forecast_data = HttpClient::get(self::API_ENDPOINT_V1 . "/forecast.json?key={$this->API_KEY}&q={$lat},{$lon}&days={$days}");
        $forecast_data = json_decode($forecast_data, true);

        if (isset($forecast_data['error'])) {
            throw new \Exception($forecast_data['error']['message']);
        }

        $forecast_days_collection = new WeatherForecastDaysCollection();

        foreach ($forecast_data['forecast']['forecastday'] as $forecast) {
            $forecast_days_collection->add(new WeatherForecastDayDTO([
                'date' => $forecast['date'],
                'condition' => $forecast['day']['condition']['text'],
            ]));
        }

        return $forecast_days_collection;
    }
}

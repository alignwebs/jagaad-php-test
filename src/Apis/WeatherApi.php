<?php

namespace Alignwebs\Apis;

use Alignwebs\Collections\MusementCitiesCollection;
use Alignwebs\Collections\WeatherForecastDaysCollection;
use Alignwebs\DTOs\WeatherForecastDayDTO;
use Alignwebs\Helpers\HttpClient;

class WeatherApi
{
    const API_ENDPOINT_V1 = "http://api.weatherapi.com/v1";

    private string $API_KEY;

    function __construct(string $apiKey)
    {
        $this->API_KEY = $apiKey;
    }

    public function fetchWeatherForecast(MusementCitiesCollection $musementCitiesCollection, int $days = 2): WeatherForecastDaysCollection
    {
        $cities = $musementCitiesCollection->toArray();

        $http_client = new HttpClient();

        foreach ($cities as $city) {
            $url = self::API_ENDPOINT_V1 . "/forecast.json?key={$this->API_KEY}&q={$city->latitude},{$city->longitude}&days={$days}";
            $http_client->addRequest('GET', $url);
        }

        $forecast_days_collection = new WeatherForecastDaysCollection();
        $responses = $http_client->sendConcurrentRequest();

        foreach ($responses as $forecast_data) {
            $forecast_data = json_decode($forecast_data, true);

            if (isset($forecast_data['error'])) {
                $forecast_days_collection->add(new WeatherForecastDayDTO([
                    'city' => $forecast_data['error']['message'],
                    'conditions' => [],
                ]));
                continue;
            }

            $city_name = $forecast_data['location']['name'];

            $conditions = [];
            foreach ($forecast_data['forecast']['forecastday'] as $forecast_day) {
                $conditions[] = $forecast_day['day']['condition']['text'];
            }

            $forecast_days_collection->add(new WeatherForecastDayDTO([
                'city' => $city_name,
                'conditions' => $conditions,
            ]));
        }
        return $forecast_days_collection;
    }
}

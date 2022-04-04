<?php

require 'src/bootstrap.php';

use Alignwebs\Modules\MusementApi\MusementApi;
use Alignwebs\Modules\WeatherApi\WeatherApi;

function process(): void
{
    // Get the list of the cities from Musement's API
    $musement = new MusementApi();
    $cities = $musement->fetchCities();

    // For each city gets the forecast for the next 2 days.
    $days = 2;
    $weather_api = new WeatherApi($_ENV['WEATHER_API_KEY']);

    foreach ($cities->get() as $musement_city_dto) {

        $forecast = $weather_api->fetchWeatherForecast($musement_city_dto->latitude, $musement_city_dto->longitude, $days);

        $weather = [];
        foreach ($forecast->get() as $forecast_day_dto) {
            $weather[] = $forecast_day_dto->condition;
        }

        $output = "Processed city {$musement_city_dto->name} | " . implode(" - ", $weather);
        fwrite(STDOUT, $output . PHP_EOL);
    }
}


try {
    process();
} catch (Exception $e) {
    fwrite(STDOUT, "Error: " . $e->getMessage() . PHP_EOL);
}

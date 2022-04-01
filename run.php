<?php

use Alignwebs\Modules\MusementApi\MusementApi;
use Alignwebs\Modules\WeatherApi\WeatherApi;

require 'src/bootstrap.php';

function process(): void
{
    // Get the list of the cities from Musement's API
    $musement = new MusementApi();
    $cities = $musement->getCities();

    // For each city gets the forecast for the next 2 days.
    $weather_api = new WeatherApi($_ENV['WEATHER_API_KEY']);

    foreach ($cities as $musement_city_dto) {
        $forecast = $weather_api->getWeatherForecast($musement_city_dto->latitude, $musement_city_dto->longitude, 2);

        $weather = [];
        foreach ($forecast as $forecast_day_dto) {
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

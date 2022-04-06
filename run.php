<?php

require 'src/bootstrap.php';

use Alignwebs\Apis\MusementApi;
use Alignwebs\Apis\WeatherApi;

function process(): void
{
    // Get the list of the cities from Musement's API
    $musement = new MusementApi();
    try {
        $cities = $musement->fetchCities();
    } catch (\Exception $e) {
        throw new \Exception("Error fetching cities from musement api: " . $e->getMessage());
    }

    // For each city gets the forecast for the next 2 days.
    $days = 2;
    $weather_api = new WeatherApi($_ENV['WEATHER_API_KEY'] = "f20eb7a39a0b402dad1173835212907");

    $weather_forecast_days_collection = $weather_api->fetchWeatherForecast($cities, $days);

    foreach ($weather_forecast_days_collection as $forecast_day_dto) {
        try {
            $output = "Processed city {$forecast_day_dto->city} | " . implode(" - ", $forecast_day_dto->conditions);
        } catch (\Exception $e) {
            $output = "Error fetching forecast from weather api: " . $e->getMessage();
        }

        fwrite(STDOUT, $output . PHP_EOL);
    }
}


try {
    // start time
    $start = microtime(true);
    // get memory usage
    $memory_usage_start = memory_get_usage();

    // Main Function
    process();

    // Calculate memory usage
    $memory_usage_end = memory_get_usage();
    $memory_usage_diff = $memory_usage_end - $memory_usage_start;
    // ouput memory usage in MB
    fwrite(STDOUT, "Memory usage: " . round($memory_usage_diff / 1024 / 1024, 2) . " MB" . PHP_EOL);
    // end time
    $end = microtime(true);
    // execution time in seconds
    $execution_time = $end - $start;
    // ouput execution time in seconds
    fwrite(STDOUT, "Execution time: " . round($execution_time, 2) . " seconds" . PHP_EOL);
} catch (Exception $e) {
    fwrite(STDOUT, $e->getMessage() . PHP_EOL);
}

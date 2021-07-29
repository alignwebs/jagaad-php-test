<?php

require 'src/bootstrap.php';

// Get the list of the cities from Musement's API
$musement = new Alignwebs\Api\Musement();
$cities = $musement->getCities();

// For each city gets the forecast for the next 2 days.
$weather = new Alignwebs\Api\Weather($_ENV['WEATHER_API_KEY']);

foreach ($cities as $city) {
    $forecast = $weather->getWeatherForecast($city['latitude'], $city['longitude'], 2);

    $weather_today = $forecast['forecast']['forecastday'][0]['day']['condition']['text'] ?? 'N/A';
    $weather_tomorrow = $forecast['forecast']['forecastday'][1]['day']['condition']['text'] ?? 'N/A';

    $output = "Processed city {$city['name']} | {$weather_today} - {$weather_tomorrow}";
    fwrite(STDOUT, $output . PHP_EOL);
}

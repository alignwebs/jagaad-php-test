<?php

require 'src/bootstrap.php';

// Get the list of the cities from Musement's API
$musement = new Alignwebs\Api\Musement();
$cities = $musement->getCities();

// For each city gets the forecast for the next 2 days.
$weather = new Alignwebs\Api\Weather($_ENV['WEATHER_API_KEY']);

print_r($cities);

<?php

namespace Alignwebs\Modules\WeatherApi;

class WeatherForecastDayDTO
{
    public string $date;
    public string $condition;

    function __construct(array $data)
    {
        $this->date = $data['date'];
        $this->condition = $data['condition'] ?? 'N/A';
    }
}

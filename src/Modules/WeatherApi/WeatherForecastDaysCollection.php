<?php

namespace Alignwebs\Modules\WeatherApi;

use Alignwebs\Modules\WeatherApi\WeatherForecastDayDTO;

class WeatherForecastDaysCollection
{
    private array $data;

    public function add(WeatherForecastDayDTO $day)
    {
        $this->data[] = $day;
    }

    public function get(): array
    {
        return $this->data;
    }
}

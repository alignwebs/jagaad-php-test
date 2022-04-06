<?php

namespace Alignwebs\Collections;

class WeatherForecastDaysCollection extends \Ramsey\Collection\AbstractCollection
{
    public function getType(): string
    {
        return 'Alignwebs\\DTOs\\WeatherForecastDayDTO';
    }
}

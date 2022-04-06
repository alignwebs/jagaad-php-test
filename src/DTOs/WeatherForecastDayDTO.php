<?php

namespace Alignwebs\DTOs;

use Spatie\DataTransferObject\DataTransferObject;

class WeatherForecastDayDTO extends DataTransferObject
{
    public string $city;
    public array $conditions;
}

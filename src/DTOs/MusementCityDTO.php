<?php

namespace Alignwebs\DTOs;

use Spatie\DataTransferObject\DataTransferObject;

class MusementCityDTO extends DataTransferObject
{
    public string $name;
    public float $latitude;
    public float $longitude;
}

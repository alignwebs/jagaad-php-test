<?php

namespace Alignwebs\Dto;

class MusementCityDto
{
    public string $name;
    public float $latitude;
    public float $longitude;

    function __construct(array $data)
    {
        $this->name = $data['name'];
        $this->latitude = $data['latitude'];
        $this->longitude = $data['longitude'];
    }
}

<?php

namespace Alignwebs\Modules\MusementApi;

class MusementCityDTO
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

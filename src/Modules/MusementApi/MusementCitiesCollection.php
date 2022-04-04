<?php

namespace Alignwebs\Modules\MusementApi;

class MusementCitiesCollection
{
    private array $cities;

    public function add(MusementCityDTO $city)
    {
        $this->cities[] = $city;
    }

    public function get(): array
    {
        return $this->cities;
    }
}

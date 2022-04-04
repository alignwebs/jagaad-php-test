<?php

namespace Alignwebs\Modules\MusementApi;

class MusementCitiesCollection
{
    private array $data;

    public function add(MusementCityDTO $city)
    {
        $this->data[] = $city;
    }

    public function get(): array
    {
        return $this->data;
    }
}

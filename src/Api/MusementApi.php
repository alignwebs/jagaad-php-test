<?php

namespace Alignwebs\Api;

use Alignwebs\Dto\MusementCityDto;
use Alignwebs\Traits\HttpClient;

class MusementApi
{
    const API_ENDPOINT_V3 = "https://api.musement.com/api/v3";

    public function getCities(): array
    {
        $cities_data = HttpClient::get(self::API_ENDPOINT_V3 . "/cities");
        $cities_data = json_decode($cities_data, true);

        // Throw exception if response is not valid - Valid response is without "code" key
        if (isset($cities_data['code'])) {
            throw new \Exception($cities_data['message']);
        }

        $cities_data = array_map(function ($city) {
            return new MusementCityDto([
                'name' => $city['name'],
                'latitude' => $city['latitude'],
                'longitude' => $city['longitude'],
            ]);
        }, $cities_data);

        return $cities_data;
    }
}

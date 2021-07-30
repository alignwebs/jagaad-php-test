<?php

namespace Alignwebs\Api;

class Musement
{
    const API_ENDPOINT_V3 = "https://api.musement.com/api/v3";

    public function getCities()
    {
        $cities = json_decode(file_get_contents(self::API_ENDPOINT_V3 . '/cities'), true);
        $cities = array_map(function ($city) {
            return [
                'name' => $city['name'],
                'latitude' => $city['latitude'],
                'longitude' => $city['longitude'],
            ];;
        }, $cities);
        return $cities;
    }
}

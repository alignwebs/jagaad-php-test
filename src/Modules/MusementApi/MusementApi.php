<?php

namespace Alignwebs\Modules\MusementApi;

use Alignwebs\Helpers\HttpClient;

class MusementApi
{
    const API_ENDPOINT_V3 = "https://api.musement.com/api/v3";

    public function fetchCities(): MusementCitiesCollection
    {
        $cities_data = HttpClient::get(self::API_ENDPOINT_V3 . "/cities");
        $cities_data = json_decode($cities_data, true);

        // Throw exception if response is not valid - Valid response is without "code" key
        if (isset($cities_data['code'])) {
            throw new \Exception($cities_data['message']);
        }

        $cities_collection = new MusementCitiesCollection();
        foreach ($cities_data as $city) {
            $cities_collection->add(new MusementCityDTO([
                'name' => $city['name'],
                'latitude' => $city['latitude'],
                'longitude' => $city['longitude'],
            ]));
        }

        return $cities_collection;
    }
}

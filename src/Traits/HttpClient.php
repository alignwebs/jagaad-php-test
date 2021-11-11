<?php

namespace Alignwebs\Traits;

class HttpClient
{
    public static function get(string $url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $output = curl_exec($ch);
        curl_close($ch);

        // check if curl has error
        if ($output === false) {
            throw new \Exception('Curl error: ' . curl_error($ch));
        }

        return $output;
    }
}

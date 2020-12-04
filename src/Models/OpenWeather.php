<?php

namespace Abbe\Models;

use Abbe\Ip\WeatherController;


class OpenWeather {
    
    private $lat;
    private $lon;
    private $data;
    private $api_key;
    private $baseurl = "https://api.openweathermap.org/data/2.5/";

    public function __construct($lat, $lon)
    {
        $this->lat = $lat;
        $this->lon = $lon;
        $this->api_key = $this->loadApikey();
        $this->data = $this->requestData();
    }

    private function loadApikey() {
        $json = file_get_contents(ANAX_INSTALL_PATH . "/config/.weatherapi.json");
        $res = json_decode($json);
        return $res->apikey;
    }

    private function getLatLon() {
        return null;        
    }

    private function requestData() {
        $url = $this->baseurl . 'onecall?lat=' . $this->lat . '&lon=' . $this->lon . '&exclude=hourly,daily&appid=' . $this->api_key;
 
        $cURL = curl_init();

        curl_setopt($cURL, CURLOPT_URL, $url);
        curl_setopt($cURL, CURLOPT_HTTPGET, true);

        curl_setopt($cURL, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json'
        ));

        $result = curl_exec($cURL);

        curl_close($cURL);
        $this->data = json_decode($result);
    }

    public function getData() {
        return $this->data;
    }
} 
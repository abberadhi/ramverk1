<?php

namespace Abbe\Models;

use Abbe\IpAddr\WeatherController;

class OpenWeather
{
    
    private $url = [];
    private $data;
    private $apiKey;
    private $baseurl = "https://api.openweathermap.org/data/2.5/";

    private function loadApikey()
    {
        $json = file_get_contents(ANAX_INSTALL_PATH . "/config/.weatherapi.json");
        $res = json_decode($json);
        return $res->apikey;
    }

    private function getLatLon($ipAddr)
    {
        $ch1 = curl_init();
        curl_setopt($ch1, CURLOPT_URL, "http://www.student.bth.se/~abra19/dbwebb-kurser/ramverk1/me/redovisa/htdocs/api/data");
        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch1, CURLOPT_POST, true);

        $data = array(
            'ip' => $ipAddr ?? $_SERVER['REMOTE_ADDR']
        );

        curl_setopt($ch1, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($ch1);
        curl_close($ch1);
        
        $data1 = json_decode($output);

        $this->data["lon"] = $data1->longitude;
        $this->data["lat"] = $data1->latitude;
        $this->data["country"] = $data1->country;
        $this->data["city"] = $data1->city;
    }

    public function requestData($ipAddr)
    {
        $this->apiKey = $this->loadApikey(); // load api key to private variable
        $this->getLatLon($ipAddr); // get latitude and longitude to private variable

        $this->url[] = $this->baseurl . 'onecall?lat=' .  $this->data["lat"] . '&lon=' . $this->data["lon"] . '&exclude=minutely,hourly&units=metric&appid=' . $this->apiKey;


        for ($i = 5; $i > 0; $i--) {
            $this->url[] = $this->baseurl . "onecall/timemachine?lat=" .  $this->data["lat"] . "&lon=" . $this->data['lon'] . "&dt=" . strtotime('-' . $i .' day') . "&exclude=minutely,hourly&units=metric&appid=" . $this->apiKey;
        }

        $nodeCount = count($this->url);

        $curlArr = array();
        $master = curl_multi_init();

        for ($i = 0; $i < $nodeCount; $i++) {
            $url =$this->url[$i];
            $curlArr[$i] = curl_init($url);
            curl_setopt($curlArr[$i], CURLOPT_RETURNTRANSFER, true);
            curl_multi_add_handle($master, $curlArr[$i]);
        }
        $isRunning = null;
        do {
            curl_multi_exec($master, $isRunning);
        } while ($isRunning > 0);

        $results = null;
        for ($i = 0; $i < $nodeCount; $i++) {
            $results[] = json_decode(curl_multi_getcontent($curlArr[$i]));
        }

        curl_multi_close($master);

        $this->data["forecast"] = $results[0];
        $this->data["timemachine"] = [$results[1], $results[2], $results[3], $results[4], $results[5]];


        return $this->data;
    }

    public function getData()
    {
        return $this->data;
    }
}

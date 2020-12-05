<?php

namespace Abbe\Models;

use Abbe\Ip\WeatherController;


class OpenWeather {
    
    private $url = [];
    private $data;
    private $api_key;
    private $baseurl = "https://api.openweathermap.org/data/2.5/";

    public function __construct($ip)
    {
        $this->getLatLon($ip);

        $this->api_key = $this->loadApikey();
        $this->data = $this->requestData();
    }

    private function loadApikey() {
        $json = file_get_contents(ANAX_INSTALL_PATH . "/config/.weatherapi.json");
        $res = json_decode($json);
        return $res->apikey;
    }

    private function getLatLon($ip) {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://www.student.bth.se/~abra19/dbwebb-kurser/ramverk1/me/redovisa/htdocs/api/data");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);

        $data = array(
            'ip' => $ip ?? $_SERVER['REMOTE_ADDR']
        );

        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($ch);
        curl_close($ch);
        
        $d = json_decode($output);

        $this->data["lon"] = $d->longitude;
        $this->data["lat"] = $d->latitude;
        
    }

    private function requestData() {
        $this->url[] = $this->baseurl . 'onecall?lat=' .  $this->data["lat"] . '&lon=' . $this->data["lon"] . '&exclude=minutely,hourly&units=metric&appid=' . $this->api_key;


        for ($i = 5; $i > 0; $i--) {
            $this->url[] = $this->baseurl . "onecall/timemachine?lat=" .  $this->data["lat"] . "&lon=" . $this->data['lon'] . "&dt=" . strtotime('-' . $i .' day') . "&appid=" . $this->api_key;
        }


        $node_count = count($this->url);

        $curl_arr = array();
        $master = curl_multi_init();

        for($i = 0; $i < $node_count; $i++)
        {
            $url =$this->url[$i];
            $curl_arr[$i] = curl_init($url);
            curl_setopt($curl_arr[$i], CURLOPT_RETURNTRANSFER, true);
            curl_multi_add_handle($master, $curl_arr[$i]);
        }

        do {
            curl_multi_exec($master,$running);
        } while($running > 0);


        for($i = 0; $i < $node_count; $i++)
        {
            $results[] = json_decode(curl_multi_getcontent  ( $curl_arr[$i]  ));
        }

        curl_multi_close($master);
        
    }

    public function getData() {
        return $this->data;
    }
} 
<?php

namespace Abbe\Weather;
use Abbe\Weather;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Exception;

class WeatherController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    /**
     * @var string $db a sample member variable that gets initialised
     */
    private $db = "not active";

    public function initialize() : void
    {
        // Use to initialise member variables.
        $this->db = "active";
        $this->page = $this->di->get("page");
    }

    public function indexActionGet()
    {

        $data = [
            "name" => "test"
        ];

        $this->page->add('mine/weather/index', $data);

        return $this->page->render(["title" => "Weather report"]);

    }

    public function indexActionPost()
    {

        $ipAddress = $this->di->request->getPost('ip') ?? "";

        $apikey = json_decode(file_get_contents(__DIR__ . '/.api.json'))->apikey;

        $json = file_get_contents('http://api.ipapi.com/' . $ipAddress .'?access_key=' . $apikey .'&format=1');
        $res = json_decode($json);


        $data = [
            "ip" => $ipAddress,
            "validipv6" => (filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) ? "Valid" : "Not Valid"),
            "validipv4" => (filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) ? "Valid" : "Not Valid"),
            "latitude" => $res->latitude,
            "longitude" => $res->longitude,
            "country" => $res->country_name,
            "city" => $res->city
        ];
        
        error_reporting(0); 
        $data["hostname"] = gethostbyaddr($ipAddress) ?? "N/A";
        error_reporting(1); 

        $this->page->add('mine/iplookup/index', $data);

        return $this->page->render(["title" => "IP Validator"]);
    }
}

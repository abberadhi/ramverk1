<?php

namespace Abbe\Controller;

use Abbe\Models\OpenWeather;
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

        $te = new OpenWeather("55.594860076904", "12.983590126038");

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
            "ip" => $ipAddress
        ];

        $this->page->add('mine/weather/index', $data);

        return $this->page->render(["title" => "Weather report"]);
    }
}

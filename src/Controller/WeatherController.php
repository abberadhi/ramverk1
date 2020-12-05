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

        $data = [
            "name" => "test"
        ];

        $this->page->add('mine/weather/index', $data);

        return $this->page->render(["title" => "Weather report"]);

    }

    public function indexActionPost()
    {

        $ipAddress = $this->di->request->getPost('ip') ?? "";
        $te = new OpenWeather($ipAddress);

        $data = [
            "lat" => $te->getData()["lat"],
            "lon" => $te->getData()["lon"]
        ];

        $this->page->add('mine/weather/index', $data);

        return $this->page->render(["title" => "Weather report"]);
    }
}

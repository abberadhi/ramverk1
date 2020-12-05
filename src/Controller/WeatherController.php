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

        try {
            $te = new OpenWeather($ipAddress);
            $data = $te->requestData();        
        } catch (Exception $e) {
            $data["message"] = "Something is wrong with the specified IP address. Please try again.";
        }
        
        $data["specifiedIP"] = $ipAddress;
        $data["name"] = "Weather";

        $this->page->add('mine/weather/index', $data);

        return $this->page->render(["title" => "Weather report"]);
    }
}

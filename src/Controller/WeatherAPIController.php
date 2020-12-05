<?php

namespace Abbe\Controller;

use Abbe\Models\OpenWeather;
use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Exception;

class WeatherAPIController implements ContainerInjectableInterface
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

    public function indexActionPost()
    {

        $ipAddress = $this->di->request->getPost('ip') ?? "";

        try {
            $te = new OpenWeather();
            $data = $te->requestData($ipAddress);        
        } catch (Exception $e) {
            $data["message"] = "Something is wrong with the specified IP address. Please try again.";
        }
        
        $data["specifiedIP"] = $ipAddress;

        return json_encode($data);
    }
}

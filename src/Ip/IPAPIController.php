<?php

namespace Abbe\Ip;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

class IPAPIController implements ContainerInjectableInterface
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

    public function dataActionPost()
    {

        $ipAddress = $this->di->request->getPost('ip') ?? null;

        if (!$ipAddress) {
            return ["Message" => "Not a valid ip"];
        }

        $data = [
            "ip" => $ipAddress,
            "validipv6" => (filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) ? true : false),
            "validipv4" => (filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) ? true : false),
        ];


        error_reporting(0); 
        $data["hostname"] = gethostbyaddr($ipAddress) ?? "N/A";
        error_reporting(1); 

        return [$data];
    }
}

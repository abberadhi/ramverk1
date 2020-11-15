<?php

namespace Abbe\Ip;
use Abbe\Ip;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Exception;

class IPLookupController implements ContainerInjectableInterface
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

        $this->page->add('mine/iplookup/index', $data);

        return $this->page->render(["title" => "IP Validator"]);

    }

    public function indexActionPost()
    {

        $ipAddress = $this->di->request->getPost('ip') ?? "";


        $data = [
            "ip" => $ipAddress,
            "validipv6" => (filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) ? "Valid" : "Not Valid"),
            "validipv4" => (filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) ? "Valid" : "Not Valid"),
        ];
        
        error_reporting(0); 
        $data["hostname"] = gethostbyaddr($ipAddress) ?? "N/A";
        error_reporting(1); 

        $this->page->add('mine/iplookup/index', $data);

        return $this->page->render(["title" => "IP Validator"]);
    }
}

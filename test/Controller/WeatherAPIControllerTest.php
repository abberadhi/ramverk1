<?php

namespace Abbe\Controller;

use Abbe\Controller\WeatherAPIController;
use Anax\Controller\SampleAppController;
use Anax\DI\DIMagic;
use Anax\Response\ResponseUtility;
use PHPUnit\Framework\TestCase;

/**
 * Test the controller like it would be used from the router,
 * simulating the actual router paths and calling it directly.
 */
class WeatherAPIControllerTest extends TestCase
{
    // private $controller;


    // /**
    //  * Setup the controller, before each testcase, just like the router
    //  * would set it up.
    //  */
    // protected function setUp(): void
    // {
    //     // Init service container $di to contain $app as a service
    //     $di = new DIMagic();
    //     $app = $di;
    //     $di->set("app", $app);

    //     // Create and initiate the controller
    //     $this->controller = new SampleAppController();
    //     $this->controller->setApp($app);
    //     $this->controller->initialize();
    // }


    protected $di;
    protected $controller;

    /**
     * Prepare before each test.
     */
    protected function setUp()
    {
        global $di;

        // Setup di
        $this->di = new DIMagic();
        $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        // Use a different cache dir for unit test
        $this->di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

        // View helpers uses the global $di so it needs its value
        $di = $this->di;

        // Setup the controller
        $this->controller = new WeatherAPIController();
        $this->controller->setDI($this->di);
        $this->controller->initialize();
    }

    public function testIndexActionGet()
    {
        $this->di->request->setGet("ip", "51.15.108.143");
        $res = $this->controller->indexActionGet();

        // lon
        $this->assertContains("4.940189838409424", $res);
        // lat
        $this->assertContains("52.309051513671875", $res);
    }

    public function testDataActionFail()
    {
        $res = $this->controller->indexActionGet();

        $this->assertContains("Something is wrong with the specified IP address. Please try again.", $res);
    }

    // public function testLatitudeIndexActionPost() {
    //     $this->di->request->setPost("ip", "51.15.108.143");
    //     $res = $this->controller->indexActionPost();

    //     $body = $res->getBody();
    //     $this->assertContains("12.983590126037598", $body);
    // }
}

<?php

namespace Abbe\Ip;
use Abbe\Ip;

use Anax\Controller\SampleAppController;
use Anax\DI\DIMagic;
use Anax\Response\ResponseUtility;
use PHPUnit\Framework\TestCase;

/**
 * Test the controller like it would be used from the router,
 * simulating the actual router paths and calling it directly.
 */
class IPAPIControllerTest extends TestCase
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
        $this->controller = new \Abbe\Ip\IPAPIController();
        $this->controller->setDI($this->di);
        $this->controller->initialize();
    }

    public function testDataActionPost() {
        $this->di->request->setPost("ip", "51.15.108.143");
        $res = $this->controller->dataActionPost();
        $this->assertContains("143-108-15-51.instances.scw.cloud", $res[0]);
    }

    public function testDataActionFail() {
        $res = $this->controller->dataActionPost();

        $this->assertContains("Not a valid ip", $res);
    }
}

<?php

namespace Abbe\Models;
use Abbe\Models\OpenWeather;

use Anax\Controller\SampleAppController;
use Anax\DI\DIMagic;
use Anax\Response\ResponseUtility;
use PHPUnit\Framework\TestCase;

/**
 * Test the controller like it would be used from the router,
 * simulating the actual router paths and calling it directly.
 */
class OpenWeatherTest extends TestCase
{
 
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
        $this->controller = new \Abbe\Models\OpenWeather();
    }

    public function testRequestDataPost() {
        $this->controller = new OpenWeather();
        $res = $this->controller->requestData("notanip");
        $this->assertContains("Nothing to geocode", serialize($res));
    }


    public function failTestRequestDataPost() {
        $this->controller = new OpenWeather();
        $res = $this->controller->requestData("51.15.108.143");
        $this->assertStringNotContainsString("Nothing to geocode", serialize($res));
    }

}

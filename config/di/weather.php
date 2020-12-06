<?php

use Abbe\Models\OpenWeather;

/**
 * Configuration file for request service.
 */
return [
    "services" => [
        "weather" => [
            "shared" => true,
            "callback" => function () {
                return new OpenWeather();
            }
        ],
    ],
]; 
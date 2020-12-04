<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "Weather checker.",
            "mount" => "weather",
            "handler" => "\Abbe\Controller\WeatherController",
        ],
    ]
];

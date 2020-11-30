<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "IP checker.",
            "mount" => "weather",
            "handler" => "\Abbe\Weather\WeatherController",
        ],
    ]
];

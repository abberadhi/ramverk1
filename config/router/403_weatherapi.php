<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "Weather checker.",
            "mount" => "weatherapi",
            "handler" => "\Abbe\Controller\WeatherAPIController",
        ],
    ]
];

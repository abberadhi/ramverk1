<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "IP checker.",
            "mount" => "api",
            "handler" => "\Abbe\Ip\IPAPIController",
        ],
    ]
];

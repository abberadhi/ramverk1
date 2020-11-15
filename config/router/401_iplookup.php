<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "IP checker.",
            "mount" => "ip",
            "handler" => "\Abbe\Ip\IPLookupController",
        ],
    ]
];

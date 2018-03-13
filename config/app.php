<?php

return [
    'defaultDomain' => 'test.com',
    'allowedDomains' => [], 
    'redis' => [
        "client" => "tcp://redis:6379",
        "prefix" => "search",
    ],
    'apiCreds' => [
        "cx" =>  "",
        "key" => "",
    ],
    'routeTemplates' => [
        "entrypoint" => "/",
        "pageSearch" => '/search{?query,start,filters}',
        "objectSearch" => "/objects/{query}",
    ],
];

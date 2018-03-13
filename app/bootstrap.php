<?php

use Doctrine\Common\Annotations\AnnotationRegistry;

$autoloader = require __DIR__.'/../vendor/autoload.php';

AnnotationRegistry::registerLoader(array($autoloader, 'loadClass'));

$config = require __DIR__."/../config/app.php";

$defaults = [
    "settings" => [
        "determineRouteBeforeAppMiddleware" => true,
    ]
];

$appConfig = array_merge($defaults, $config);

$container = new \Slim\Container($appConfig);
$app = new \Slim\App($container);

require __DIR__ ."/providers.php"; 
require __DIR__ ."/routes.php"; 

return $app;

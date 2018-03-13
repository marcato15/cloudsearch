<?php

use Search\Controllers as Controllers;
use Search\Middleware as Middleware;
use Hateoas\UrlGenerator\CallableUrlGenerator;
use Hateoas\HateoasBuilder;
use QL\UriTemplate\Expander;

//Add Items to Container
$container = $app->getContainer();

$redisConfig = $container->get("redis");
$redisClient = new \Predis\Client($redisConfig["client"], [
    'prefix' => $redisConfig["prefix"],
]);
$app->add(new \SlimRedisCache\Middleware($redisClient, [
    'timeout' => 300
]));

//Add Middleware
$app->add(new Middleware\CorsMiddleware($container));


$container['uriTemplate'] = function($c) {
    return new Expander();
};


$container['urlGenerator'] = function($c) use ($container) {
    return new CallableUrlGenerator(function ($route, array $parameters, $absolute) use ($container) {
        $routeTemplate = $container->get('routeTemplates')['route'];
        if (count($parameters) > 0) {                               
            return $container["uriTemplate"]->__invoke($routeTemplate,$parameters, ["preserveTpl" => true]);
        }                                                           

        return $routeTemplate;   
    });
};

$container['serializer'] = function($c) use ($container) {

    $hateoas = HateoasBuilder::create()
        ->setUrlGenerator(null,$container['urlGenerator'])
        ->build();

    return $hateoas;
};


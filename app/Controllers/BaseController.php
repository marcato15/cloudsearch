<?php

namespace Search\Controllers;

use GuzzleHttp\Client;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


class BaseController { 

     public function __construct(\Slim\Container $container) {
       $this->container = $container;
   }
    
    public function serializeResponse($object, Response $response)
    {
        $json = $this->container['serializer']->serialize($object,'json');
        
        $response = $response->withHeader('Content-type', 'application/json'); 

        $body = $response->getBody();

        $body->write($json);

        return $response;
    }

}

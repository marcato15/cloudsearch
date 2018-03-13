<?php

namespace Search\Tests\Functional;

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Environment;
use PHPUnit\Framework\TestCase;

class BaseTestCase extends TestCase
{
    /**
     * Process the application given a request method and URI
     *
     * @param string $requestMethod the request method (e.g. GET, POST, etc.)
     * @param string $requestUri the request URI
     * @param array|object|null $requestData the request data
     * @return \Slim\Http\Response
     */
    public function runApp($requestMethod, $requestUri, $requestData = null, array $headers = [])
    {
        $default = [
            'REQUEST_METHOD' => $requestMethod,
            'REQUEST_URI' => $requestUri,
        ];

        $config = array_merge($default, $headers);
        
        // Create a mock environment for testing with
        $environment = Environment::mock($config);
        
        // Set up a request object based on the environment
        $request = Request::createFromEnvironment($environment);

        // Add request data, if it exists
        if (isset($requestData)) {
            $request = $request->withParsedBody($requestData);
        }
        // Set up a response object
        $response = new Response();
        
        // Load up the app from bootstrap
        $app = require __DIR__."/../../app/bootstrap.php";
        
        // Process the application
        $response = $app->process($request, $response);
        // Return the response
        return $response;
    }
}

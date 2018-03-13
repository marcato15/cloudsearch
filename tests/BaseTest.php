<?php

namespace Tests\Functional;

use Slim\Http\Environment;
use Slim\Http\Request;
use PHPUnit\Framework\TestCase;


class SearchTest extends TestCase
{
    /**
     * Use middleware when running application?
     *
     * @var bool
     */
    protected $withMiddleware = true;
    /**
     * Process the application given a request method and URI
     *
     * @param string $requestMethod the request method (e.g. GET, POST, etc.)
     * @param string $requestUri the request URI
     * @param array|object|null $requestData the request data
     * @return \Slim\Http\Response
     */
    public function runApp($requestMethod, $requestUri, $requestData = null)
    {
        // Create a mock environment for testing with
        $environment = Environment::mock(
            [
                'REQUEST_METHOD' => $requestMethod,
                'REQUEST_URI' => $requestUri
            ]
        );
        // Set up a request object based on the environment
        $request = Request::createFromEnvironment($environment);
        // Add request data, if it exists
        if (isset($requestData)) {
            $request = $request->withParsedBody($requestData);
        }
        // Set up a response object
        $response = new Response();
        
        $app = require "../app/bootstrap.php";
        
        // Process the application
        $response = $app->process($request, $response);
        // Return the response
        return $response;
    }
}

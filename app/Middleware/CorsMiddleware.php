<?php

namespace Search\Middleware;

class CorsMiddleware
{

    private $allowedDomains, $defaultDomain;

    public function __construct($container) {
        $this->allowedDomains = $container->get("allowedDomains");
        $this->defaultDomain = $container->get("defaultDomain");
    }

    /**
     * corse  middleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {
        $response = $next($request, $response);
        if(empty($request->getHeader("HTTP_ORIGIN"))){
            return $response;
        }
        $methods = ["GET","POST","DELETE","PUT"];


        $corsDomain = $this->defaultDomain;

        foreach($this->allowedDomains as $domain){
            if( strpos($request->getHeader("HTTP_ORIGIN"), $domain) !== -1){
                $corsDomain = $domain;
            }
        }

        return $response
            ->withHeader("Access-Control-Allow-Methods", implode(",", $methods))
            ->withHeader("Access-Control-Allow-Origin", $corsDomain);

    }
}

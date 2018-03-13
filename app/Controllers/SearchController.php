<?php

namespace Search\Controllers;

use Search\Entities;
use Search\Providers\GoogleSearch;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


class SearchController extends BaseController {


    public function entrypoint (Request $request, Response $response, $args)
    {
        $entrypoint = new Entities\EntryPoint;

        $response = $this->serializeResponse($entrypoint,$response);

        return $response;
    }

    public function pageSearch (Request $request, Response $response, $args)
    {
        $params = $request->getQueryParams();

        $searchRequest = new Entities\SearchRequest($params);

        $searchProvider = new GoogleSearch\Provider();

        $searchResult = $searchProvider->runSearch($searchRequest);
        
        $searchResult->attachRequest($searchRequest);

        $response = $this->serializeResponse($searchResult,$response);

        return $response;
    }
}

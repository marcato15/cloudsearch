<?php

namespace Search\Providers\GoogleSearch;

use Search\Interfaces;
use Search\Entities;
use GuzzleHttp\Client;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

class Provider  {

    public function runSearch(Entities\SearchRequest $searchRequest)
    {
        $requestTransformer = new RequestTransformer($searchRequest);

        $resultTransformer = $this->_sendSearch($requestTransformer);

        $searchResult = $resultTransformer->createSearchResult(); 

        return $searchResult;
    
    }


    private function _sendSearch(RequestTransformer $requestTransformer)
    {
        //Create Client
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://www.googleapis.com/customsearch/v1',
            // You can set any number of default request options.
            'timeout'  => 10.0,
        ]);

        $creds = [
            "cx" => "",
            "key" => "",
        ];

        $queryParams = array_merge($creds, $requestTransformer->getQueryParams());
        
        $res = $client->request("GET",'',[
            "query" => $queryParams,
            ]
        );
        
        $googleResponse = json_decode($res->getBody(),true);
        
        $resultTransformer = new ResultTransformer($googleResponse);
        
        return $resultTransformer;

    }
}

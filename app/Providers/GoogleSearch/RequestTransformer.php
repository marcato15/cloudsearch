<?php

namespace Search\Providers\GoogleSearch;

use Search\Interfaces;
use Search\Entities;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

class RequestTransformer {
    
    private $params = [];
    private $searchRequest;

    public function __construct(Entities\SearchRequest $searchRequest = null)
    {
        if(!is_null($searchRequest)){
            $this->setSearchRequest($searchRequest);
        }
    }

    public function setSearchRequest($searchRequest)
    {
        $this->searchRequest = $searchRequest;
        $this->processSearchRequest();
    }

    public function processSearchRequest()
    {
        $this->_processQuery();
        $this->_processFilters();
        $this->_processPagination();
    }

    private function _processFilters()
    {
        $filters = $this->searchRequest->filters;

        $params = []; 
        $params[] = $this->params['q'];

        foreach($filters as $key => $filter)
        {
            switch($key){
                case "siteSection":
                    $params[] = "more:{$filter}"; 
                    break;
                case "pageType":
                    $params[] = "more:p:metatags-pagetype:{$filter}";
                    break;
                case "resourceType":
                    $params[] = "more:resource_{$filter}";
                    break;
                case "authorName":
                    $params[] = "more:p:creativework-author:{$filter} OR more:p:blogposting-author:{$filter} OR more:p:book-author:{$filter}";
                    break;
                case "mediaType":
                    switch($filter){
                        case "video":
                            $params[] = "more:p:videoobject";
                        case "audio":
                            $params[] = "more:p:audioobject";
                        case "document":
                            $params[] = "more:p:datadownload";
                    }
                    break;
            }
        }

        $this->params['q'] = implode(" ",$params);
    }


    private function _processQuery()
    {
        $this->params['q'] = $this->searchRequest->query; 
    }


    private function _processPagination()
    {
        $this->params['start'] = $this->searchRequest->start_no;
    }


    public function getQueryParams()
    {
        return $this->params;
    }
}


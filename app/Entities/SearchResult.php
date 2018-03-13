<?php

namespace Search\Entities;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * The representation of an result within the api system.
 *
 * @Serializer\AccessType("public_method")
 * @Serializer\ReadOnly
 *
 * @Hateoas\Relation(
 *     "self",
 *     href = @Hateoas\Route("pageSearch",
 *        parameters = {
 *             "query":  "expr(object.getRequest().query)",
 *            }
 *        )
 * )
 *
 * @Hateoas\Relation(
 *     "prevPage",
 *     href = @Hateoas\Route("pageSearch",
 *        parameters = {
 *             "query":  "expr(object.getRequest().query)",
 *             "start": "expr(object.getInfo()['prevPage'])",
 *            }
 *        ),
 *     exclusion = @Hateoas\Exclusion(excludeIf = "expr(object.getInfo()['prevPage'] === false)")
 * )
 *
 * @Hateoas\Relation(
 *     "nextPage",
 *     href = @Hateoas\Route("pageSearch",
 *        parameters = {
 *             "query":  "expr(object.getRequest().query)",
 *             "start": "expr(object.getInfo()['nextPage'])",
 *            }
 *        ),
 *     exclusion = @Hateoas\Exclusion(excludeIf = "expr(object.getInfo()['nextPage'] === false)")
 * )
 *
 *
 *
 *
 *
 **/


class SearchResult  {

    private $request;
    private $info = ["total"=>null,"start"=>null,"perPage"=>10];
    private $results = [];


    public function attachRequest($searchRequest)
    {
        $this->request = $searchRequest;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function getResults()
    {
        return $this->results;
    }

    public function setResults(Array $searchResultItems)
    {
        foreach($searchResultItems as $searchResultItem)
        {
            $this->setResultItem($searchResultItem);
        }
    }

    public function setResultItem(SearchResultItem $searchResultItem)
    {
        $this->results[] = $searchResultItem;
    }

    public function getInfo()
    {
        return $this->info;
    }

    public function setInfo(Array $info)
    {
        $allowedValues = array_intersect_key($info,$this->info);
        $this->info = array_merge($this->info,$allowedValues);
        $this->updatePagination();
    }

    public function updatePagination()
    {
        $this->info['nextPage'] = false;
        $this->info['prevPage'] = false;

        $nextPageIndex = $this->info['start'] + $this->info['perPage']; 
        $prevPageIndex = $this->info['start'] - $this->info['perPage']; 

        if($nextPageIndex <= $this->info['total']){
            $this->info['nextPage'] = $nextPageIndex;
        }

        if($prevPageIndex > 0){
            $this->info['prevPage'] = $prevPageIndex; 
        }
        
    }

    public function getPageForIndex($index)
    {
        if(!is_numeric($index)){
            return false;
        }
        $page = floor(($index - 1) / 10) + 1;
        return $page;
    }

}


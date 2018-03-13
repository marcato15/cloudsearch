<?php

namespace Search\Providers\GoogleSearch;

use Search\Entities;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

class ResultTransformer  {

    private $resultData;

    public function __construct($googleResponse)
    {
        $this->resultData = $googleResponse;
    }

    public function createSearchResult()
    {
        $searchResult = new Entities\SearchResult(); 
        $searchResult->setResults($this->getResultItems());
        $searchResult->setInfo($this->getInfo());
        return $searchResult;
    }

    public function getResultItems()
    {
        $items = [];

        if(!isset($this->resultData['items'])){
            return $items;
        }

        foreach($this->resultData['items'] as $item)
        {
            $items[] = $this->createSearchResultItem($item);
        }

        return $items;

    }

    public function createSearchResultItem($itemData)
    {
        $searchResultItem = new Entities\SearchResultItem();
        $searchResultItem->title = $itemData['htmlTitle']; 
        $searchResultItem->link = $itemData['link'];
        $searchResultItem->snippet = $itemData['htmlSnippet']; 
        $searchResultItem->meta = $this->getMeta($itemData);
        return $searchResultItem;
    }


    public function getMeta($itemData)
    {
        $meta = $itemData['pagemap'];

        //Google does this weird thing where everything's an array, when it doesn't need to be
        foreach($meta as $field => $children){
            reset($children);
            if(count($children) == 1 && key($children) == 0){
                $meta[$field] = $children[0]; 
            } 
        }

        return $meta;
    }

    public function getInfo()
    {
        $info = [];

        $request = $this->resultData['queries']['request'][0];

        $info['total'] = $request['totalResults'];
        $info['start'] = $request['startIndex'];

        return $info;
    }

}


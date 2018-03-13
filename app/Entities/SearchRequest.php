<?php

namespace Search\Entities;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;



class SearchRequest  {

    public $query;
    public $filters;
    public $start_no;
    public $per_page;

    public function __construct(Array $params)
    {
        $this->query = isset($params['query']) ? $params['query'] : null; 

       //filters come in via json format, so just add brackets to make an array 
        $filterString = isset($params['filters']) ? $params['filters'] : ""; 

        //Split by commas
        $filters = explode(",",$filterString);
        $finalFilters = [];
        foreach($filters as $filter){
            $vars = explode(":",$filter);
            if(count($vars) == 2){  
                $finalFilters[$vars[0]] = $vars[1];            
            }
        }

        $this->filters = $finalFilters;
        $this->start_no = isset($params['start']) ? $params['start'] : null; 
        $this->page_no = isset($params['num']) ? $params['num'] : null; 
    
    }

}


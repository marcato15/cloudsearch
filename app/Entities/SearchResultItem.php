<?php

namespace Search\Entities; 
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * The representation of an individual search result item within the api system
 **/

class SearchResultItem { 

public $title;
public $link;
public $snippet;
public $meta;
public $siteSection;

}


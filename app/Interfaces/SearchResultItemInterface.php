<?php

namespace Search\Interfaces;

interface SearchResultItemInterface{

    public function getTitle();
    public function getLink();
    public function getSnippet();
    public function getResultType();
    
}

<?php

namespace Search\Interfaces;

interface SearchRequestItemInterface{

    public function setQuery();
    public function getQuery();
    public function setFilters();
    public function getFilters();
    public function setStart();
    public function getStart();

}

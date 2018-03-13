<?php

use Search\Controllers;

//Entry Point
$app->get('/', Controllers\SearchController::class . ':entrypoint')->setName('entrypoint');

$app->get('/search', Controllers\SearchController::class . ':pageSearch')->setName('pageSearch'); 

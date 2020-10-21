<?php
require_once __DIR__.'/../controllers/AuthorController.php';
$authorControl = new AuthorController();

$router->get('/author',[$authorControl, 'getAll']);
$router->get('/author/([0-9\-]+)',[$authorControl,'getAuthor']);
$router->post('/author',[$authorControl,'register']);
$router->post('/author/([0-9\-]+)',[$authorControl,'updAuthor']);
$router->get('/author/([0-9\-]+)/delete',[$authorControl,'delAuthor']);
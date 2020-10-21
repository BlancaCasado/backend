<?php
require_once __DIR__.'/../controllers/GenreController.php';
$genreControl = new GenrerController();

$router->get('/genre',[$genreControl, 'getAll']);
$router->get('/genre/([0-9\-]+)',[$genreControl,'getGenre']);
$router->post('/genre',[$genreControl,'register']);
$router->post('/genre/([0-9\-]+)',[$genreControl,'updGenre']);
$router->get('/genre/([0-9\-]+)/delete',[$genreControl,'delGenre']);
<?php
require_once __DIR__.'/../controllers/WorkController.php';
$workControl = new WorkController();

$router->get('/work',[$workControl, 'getAll']);
$router->get('/work/([0-9\-]+)',[$workControl,'getWork']);
$router->post('/work',[$workControl,'register']);
$router->post('/work/([0-9\-]+)',[$workControl,'updWork']);
$router->get('/work/([0-9\-]+)/delete',[$workControl,'delWork']);
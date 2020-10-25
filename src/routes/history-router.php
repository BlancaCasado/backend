<?php
require_once __DIR__.'/../controllers/HistoryController.php';
$historyControl = new HistoryController();

$router->get('/history',[$historyControl, 'getAll']);
$router->get('/history/([0-9\-]+)',[$historyControl,'getHistory']);
$router->post('/history',[$historyControl,'register']);
$router->post('/history/([0-9\-]+)',[$historyControl,'updHistory']);
$router->get('/history/([0-9\-]+)/delete',[$historyControl,'delHistory']);
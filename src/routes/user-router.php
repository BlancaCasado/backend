<?php
require_once __DIR__.'/../controllers/UserController.php';
$userControl = new UserController();

// AUTH
$router->post('/login',[$userControl, 'login']);
$router->post('/register',[$userControl,'register']);
$router->post('/recover-password',[$userControl,'recoverPasswd']);

// PERFIL
$router->middleware('Auth')->get('/profile',[$userControl,'getProfile']);
$router->middleware('Auth')->post('/changePasswd',[$userControl,'changePasswd']);

// Admin
$router->middleware('Auth:1')->get('/user',[$userControl,'getAll']);
$router->middleware('Auth:1')->get('/user/([0-9\-]+)',[$userControl,'getUser']);
<?php

require_once 'vendor/autoload.php';
require 'config.php';
require './utils/utils_autoload.php';


$router = new Router\Router('/');

/**** CARGA TODAS LAS RUTAS ****/

// $router->add('/(.*)', function ($a) {
//     echo '<h1>'.$a.'</h1>';
// });


require './core/Routes_autoload.php';




$router->add('/.*', function () {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    echo '<h1>404 - El sitio solicitado no existeee</h1>';
});

$router->route();



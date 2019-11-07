<?php

global $routes;

$routes['/'] = '/home/index';
$routes['/contato'] = '/home/contato';
$routes['/teste/{id}'] = '/home/teste/:id';
$routes['/teste/{id}/{var}'] = '/home/teste/:id/:var';
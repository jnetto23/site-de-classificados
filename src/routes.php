<?php

global $routes;

$routes['/']                      = '/home/index';

$routes['/cadastre-se']           = '/auth/signup';
$routes['/login']                 = '/auth/signin';
$routes['/logout']                = '/auth/logout';

$routes['/meus-anuncios']         = '/ads/index';
$routes['/novo-anuncios']         = '/ads/add';
$routes['/editar-anuncios/{id}']  = '/ads/edit/:id';
$routes['/excluir-anuncios/{id}'] = '/ads/del/:id';

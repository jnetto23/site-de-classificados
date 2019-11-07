<?php

global $routes;

$routes['/']                      = '/home/index';
$routes['/anuncio/{:id}']         = '/home/ads/:id';

$routes['/cadastre-se']           = '/auth/signup';
$routes['/login']                 = '/auth/signin';
$routes['/logout']                = '/auth/logout';

$routes['/meus-anuncios']         = '/ads/index';
$routes['/novo-anuncios']         = '/ads/add';
$routes['/editar-anuncio/{id}']   = '/ads/edit/:id';
$routes['/excluir-anuncio/{id}']  = '/ads/del/:id';

<?php

global $routes;

$routes['/']                    = '/home/index';

$routes['/cadastre-se']         = '/auth/signup';
$routes['/login']               = '/auth/signin';
$routes['/logout']              = '/auth/logout';

$routes['/meus-anuncios']       = '/ads/index';
$routes['/add-anuncios']        = '/ads/add';
$routes['/edit-anuncios/{id}']  = '/ads/edit/:id';
$routes['/del-anuncios/{id}']   = '/ads/del/:id';

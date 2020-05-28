<?php

use \Fyyb\Router;
use \Fyyb\Request;
use \Fyyb\Response;

// Load Controllers
use App\Controllers\HomeController;
use App\Controllers\SigninController;
use App\Controllers\SignupController;
use App\Controllers\SignoutController;
use App\Controllers\AdsController;

// Load Middlewares
use App\Middlewares\AuthMiddleware;

// Routes without Authentication
$this->group('/', function($group) {
    // Signin
    $group->get('/login', SigninController::class.":index");
    $group->post('/login', SigninController::class.":create");
    
    // Signup
    $group->get('/cadastre-se', SignupController::class.":index");
    $group->post('/cadastre-se', SignupController::class.":create");
    
    // Home Page
    $group->get('/', HomeController::class.":index");
    $group->get('/anuncio/:id', HomeController::class.":show");
});

// Routes with Authentication
$this->group('/', function($group) {
    // Logout
    $group->get('/logout', SignoutController::class.":index");

    // Ads
    $group->get('/meus-anuncios', AdsController::class.":index");
    $group->map(['GET', 'POST'], '/adicionar-anuncio', AdsController::class.":create");
    $group->map(['GET', 'POST'], '/editar-anuncio/:id', AdsController::class.":update");
    $group->get('/excluir-anuncio/:id', AdsController::class.":delete");
    
})->add(AuthMiddleware::class.":verifyAuth");
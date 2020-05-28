<?php
session_start();

require __DIR__ . "./settings.php";
require __DIR__ . "./vendor/autoload.php";

use Fyyb\Router;

$app = Router::getInstance();

$app->use('/', './App/routes');

$app->run();
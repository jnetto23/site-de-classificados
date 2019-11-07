<?php  
session_start();

require '../vendor/autoload.php';

use \Fyyb\Core\Core;

$c = new Core();
$c->run();
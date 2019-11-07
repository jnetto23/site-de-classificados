<?php
session_start();
require 'config.php';

if(isset($_GET['url']) && !empty($_GET['url'])) {
    $url = array_shift($_GET);
    $p = file_exists('./pages/' . $url . '.php') ? './pages/' . $url . '.php' : './pages/404.php';
    require $p; 
} else {
    require './pages/index.php';
};
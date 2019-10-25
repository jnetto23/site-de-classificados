<?php
session_start();
require 'config.php';

if(isset($_GET['url']) && !empty($_GET['url'])) {
    $p = file_exists('./pages/' . $_GET['url'] . '.php') ? './pages/' . $_GET['url'] . '.php' : './pages/404.php';
    require $p; 
} else {
    require './pages/index.php';
};
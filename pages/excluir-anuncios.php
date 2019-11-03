<?php 
    if(!isset($_SESSION['cLogin']) || empty($_SESSION['cLogin'])) { 
        header('Location: ./login'); 
        exit;
    };

    if(isset($_GET['id']) && !empty($_GET['id'])) {
        require './class/ads.class.php';
        $ads = new Ads();
        $ads->delete($_GET['id']);
    };

    header('Location: ./meus-anuncios');
?>
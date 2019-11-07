<?php

namespace Fyyb\Controllers;

use \Fyyb\Core\Controller;
use \Fyyb\Models\Ads;

class AdsController extends Controller
{
    public function __construct() 
    {
        if (!isset($_SESSION['cLogin']) || empty($_SESSION['cLogin'])) 
        { 
            header('Location: '.BASE_URL.'login'); 
            exit;
        };
    }
    public function index()
    {   
        
        $ads = new Ads();
        
        $data = array(
            'ads' => $ads->getUserList()
        );

        $this->loadViewInTemplate('meus-anuncios', $data, 'template');
    }

    public function add()
    {   
        $data = array();
        $this->loadViewInTemplate('', $data, 'template');
    }

    public function adit($id)
    {   
        $data = array();
        $this->loadViewInTemplate('', $data, 'template');
    }

    public function del($id)
    {   
        $data = array();
        $this->loadViewInTemplate('', $data, 'template');
    }
}
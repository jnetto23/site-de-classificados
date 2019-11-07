<?php

namespace Fyyb\Controllers;

use \Fyyb\Core\Controller;
use \Fyyb\Models\User;

class HomeController extends Controller
{
    public function index()
    {   
        $u = new User();
        
        $data = array(
            'name' => $u->getName(),
            'age' => $u->getIdade()
        );
        $this->loadViewInTemplate('home', $data, 'template');
    }

    public function contato()
    {
        echo 'contato';
    }
    public function teste($data, $var = '')
    {
        echo '<pre>';
        print_r($data);
        print_r($var);
        exit;
    }
}
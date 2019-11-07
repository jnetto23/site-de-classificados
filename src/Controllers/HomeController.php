<?php

namespace Fyyb\Controllers;

use \Fyyb\Core\Controller;
use \Fyyb\Models\User;

class HomeController extends Controller
{
    public function index()
    {   
        $data = array();
        $this->loadViewInTemplate('home', $data, 'template');
    }
}
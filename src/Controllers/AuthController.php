<?php

namespace Fyyb\Controllers;

use \Fyyb\Core\Controller;
use \Fyyb\Models\User;

class AuthController extends Controller
{
    public function signup()
    {   
        $data = array();
        $this->loadViewInTemplate('', $data, 'template');
    }
    
    public function signin()
    {   
        $data = array();
        $this->loadViewInTemplate('', $data, 'template');
    }
    
    public function logout()
    {   
        $data = array();
        $this->loadViewInTemplate('', $data, 'template');
    }
}
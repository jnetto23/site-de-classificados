<?php

namespace Fyyb\Controllers;

use \Fyyb\Core\Controller;
use \Fyyb\Models\User;

class AdsController extends Controller
{
    public function index()
    {   
        $data = array();
        $this->loadViewInTemplate('', $data, 'template');
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
<?php

namespace Fyyb\Controllers;

use \Fyyb\Core\Controller;

class NotfoundController extends Controller
{
    public function index()
    {
        $data = array('error' => 404);
        $this->loadViewInTemplate('404', $data, 'template');
    }
}
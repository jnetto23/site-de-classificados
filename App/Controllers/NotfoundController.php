<?php

namespace App\Controllers;

use \Fyyb\Request;
use \Fyyb\Response;

use App\Helpers\Controller;

class NotfoundController extends Controller
{
    public function index(Request $req, Response $res)
    {
        $this->loadViewInTemplate('', ['error' => 404], 'template');
    }
}
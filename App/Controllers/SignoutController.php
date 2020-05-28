<?php

namespace App\Controllers;

use Fyyb\Request;
use Fyyb\Response;

use App\Helpers\Controller;

class SignoutController extends Controller
{
    public function index(Request $req, Response $res)
    {
        unset($_SESSION['User']);
        $res->redirect(BASE_URL);
    }
}
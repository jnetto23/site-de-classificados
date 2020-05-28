<?php

namespace App\Middlewares;

use \Fyyb\Request;
use \Fyyb\Response;

class AuthMiddleware
{
    public function verifyAuth(Request $req, Response $res, $next)
    {
        if(isset($_SESSION['User']['id']) && !empty($_SESSION['User']['id'])) {
            return $next($req, $res);
        };

        $res->redirect(BASE_URL.'login');
    }
}
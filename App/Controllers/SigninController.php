<?php

namespace App\Controllers;

use \Fyyb\Request;
use \Fyyb\Response;
use \Fyyb\Support\DataValidation;

use App\Helpers\Controller;
use App\Dao\UserDao;
use App\Models\User;

class SigninController extends Controller
{
    public function index(Request $req, Response $res)
    {
        $this->loadViewInTemplate('signin', [], 'template');
    }

    public function create(Request $req, Response $res)
    {
        $params = $req->getParsedBody();
        
        if(!(new DataValidation())->verify($params, ['email', 'pwd'])) {
            $_SESSION['error'] = 'Preencha todos os campos!';
            $res->redirect(BASE_URL.'login');
        };
        
        $email = filter_var($params['email'], FILTER_VALIDATE_EMAIL);
        $pwd = filter_var($params['pwd'], FILTER_SANITIZE_STRING);
        
        if(!$email || !$pwd) {
            $_SESSION['error'] = 'Dados inválidos!';
            $res->redirect(BASE_URL.'login');    
        };
        
        $user = new UserDao();
        $user->setEmail($email);
        $user->setPwd($pwd);
        
        if(!User::signin($user)) {
            $_SESSION['error'] = 'Email e/ou senha inválidos!';
            $res->redirect(BASE_URL.'login');    
        };

        $res->redirect(BASE_URL);
    }
}
<?php

namespace App\Controllers;

use \Fyyb\Request;
use \Fyyb\Response;
use \Fyyb\Support\DataValidation;

use App\Helpers\Controller;
use App\Dao\UserDao;
use App\Models\User;

class SignupController extends Controller
{
    public function index(Request $req, Response $res)
    {
        $this->loadViewInTemplate('signup', [], 'template');
    }

    public function create(Request $req, Response $res)
    {
        $params = $req->getParsedBody();
        if(!(new DataValidation())->verify($params, ['name', 'email', 'pwd'])) {
            $_SESSION['msg']['class'] = 'danger';
            $_SESSION['msg']['msg'] = 'Preencha todos os campos!';
            $res->redirect(BASE_URL.'cadastre-se');
        };

        $name = filter_var($params['name'], FILTER_SANITIZE_STRING);
        $email = filter_var($params['email'], FILTER_VALIDATE_EMAIL);
        $pwd = filter_var($params['pwd'], FILTER_SANITIZE_STRING);

        if(!$name || !$email || !$pwd) {
            $_SESSION['msg']['class'] = 'danger';
            $_SESSION['msg']['msg'] = 'Dados inválidos!';
            $res->redirect(BASE_URL.'cadastre-se');    
        };

        $user = new UserDao();
        $user->setName($name);
        $user->setEmail($email);
        $user->setPwd($pwd);
        
        if(!User::signup($user)) {
            $_SESSION['msg']['class'] = 'warning';
            $_SESSION['msg']['msg'] = "Email já Cadastrado.<br/> 
            <a class='alert-link' href='./login'>Faça o login agora.</a>";
        } else {
            $_SESSION['msg']['class'] = 'success';
            $_SESSION['msg']['msg']   = "<strong>Parabéns!</strong> Usuário cadastrado com sucesso.<br/>
            <a class='alert-link' href='./login'>Faça o login agora.</a>";
        };
        
        $res->redirect(BASE_URL.'cadastre-se');
    }
}
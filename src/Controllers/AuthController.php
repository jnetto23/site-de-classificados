<?php

namespace Fyyb\Controllers;

use \Fyyb\Core\Controller;
use \Fyyb\Models\User;

class AuthController extends Controller
{
    public function signup()
    {   
        $data = array();
        
        if (isset($_POST['name'])) {
            if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['pwd'])) {
                $data['msg']['class'] = 'danger';
                $data['msg']['msg']   = 'Preencha todos os campos!';
                
            } else {
                $user  = new User();
                $name  = addslashes(ucwords(strtolower(trim($_POST['name']))));
                $email = addslashes(strtolower(trim($_POST['email'])));
                $pwd   = addslashes($_POST['pwd']);
                
                if(!$user->signup($name, $email, $pwd)) {
                    $data['msg']['class'] = 'warning';
                    $data['msg']['msg'] = "Email já Cadastrado. 
                    <a class='alert-link' href='".BASE_URL."login'>Faça o login agora.</a>";
                } else {
                    $data['msg']['class'] = 'success';
                    $data['msg']['msg']   = "<strong>Parabéns!</strong> Usuário cadastrado com sucesso.
                    <a class='alert-link' href='".BASE_URL."login'>Faça o login agora.</a>";
                };
            };
        };      
        
        $this->loadViewInTemplate('signup', $data, 'template');
    }
    
    public function signin()
    {   
        $data = array();

        if (isset($_POST['email'])) {
            if (empty($_POST['email']) || empty($_POST['pwd'])) {
                $data['error'] = 'Preencha todos os campos!';

            } else {
                
                $user  = new User();
                $email = addslashes(strtolower(trim($_POST['email'])));
                $pwd   = addslashes($_POST['pwd']);

                if (!$user->signin($email, $pwd)) {
                    $data['error'] = 'Email e/ou Senha inválidos';

                } else {
                    header('Location: '.BASE_URL);
                };
            };
        };

        $this->loadViewInTemplate('signin', $data, 'template');
    }
    
    public function logout()
    {   
        unset($_SESSION['cLogin']);
        header('Location: ./');
    }
}
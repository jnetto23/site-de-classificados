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
        $data = array();
        $this->loadViewInTemplate('', $data, 'template');
    }
}
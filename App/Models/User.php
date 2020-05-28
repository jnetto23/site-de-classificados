<?php

namespace App\Models;

use \Fyyb\Support\Sql;
use App\Dao\UserDao;

const SESSION = 'User';

class User
{
    public function getTotal() 
    {
        $sql = new Sql(DB);
        $sql = $sql->query("SELECT COUNT(`id`) as c FROM `users`");
        return $sql->fetch()['c'];
    }

    public function signup(UserDao $u) 
    {
        $sql = new Sql(DB);
        $sql = $sql->query("CALL sp_user_signup(:name, :email, :pwd)", [
            ":name" => $u->getName(),
            ":email" => $u->getEmail(),
            ":pwd" => $u->getPwd()
        ]);

        $res = $sql->fetch();
        return (!isset($res['error']));
    }

    public function signin(UserDao $u) 
    {
        $sql = new Sql(DB);
        $sql = $sql->query("SELECT * FROM `users` WHERE `email` = :email and `pwd` = :pwd", [
            ":email" => $u->getEmail(),
            ":pwd" => $u->getPwd()
        ]);

        if ($sql->rowCount() > 0) {
            $u->setData($sql->fetch());
            
            $res = $u->getData();
            $_SESSION[SESSION] = $res;
            
            return true;
        };
        
        return false;
    }
};
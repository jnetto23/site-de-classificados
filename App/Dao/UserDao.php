<?php

namespace App\Dao;

use Fyyb\Support\Model;

class UserDao extends Model
{
    public function setName($name)
    {
        $this->data['name'] = addslashes(ucwords(strtolower(trim($name))));
        return;
    }

    public function setEmail($email)
    {
        $this->data['email'] = addslashes(strtolower(trim($email)));
        return;
    }

    public function setPwd($pwd)
    {
        $this->data['pwd'] = md5(addslashes($pwd));
        return;
    }
}
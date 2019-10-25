<?php
require './class/db.class.php';

class User extends DB {
    public function __construct() {
        parent::__construct();
    }

    public function signup($name, $email, $pwd) {
        $sql = "CALL sp_users_signup(:name, :email, :pwd)";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':name', $name);
        $sql->bindValue(':email', $email);
        $sql->bindValue(':pwd', md5($pwd));
        $sql->execute();

        $res = $sql->fetch();
        return (!isset($res['error'])) ? true: false;

    }
};
<?php
include_once './class/db.class.php';

class User extends DB {
    public function __construct() {
        parent::__construct();
    }

    public function getTotal() {
        $users = $this->pdo->query('SELECT COUNT(id) as c FROM users');
        $users = $users->fetch()['c'];

        return $users;
    }

    public function signup($name, $email, $pwd) {
        $sql = "CALL sp_user_signup(:name, :email, :pwd)";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':name', $name);
        $sql->bindValue(':email', $email);
        $sql->bindValue(':pwd', md5($pwd));
        $sql->execute();

        $res = $sql->fetch();
        return (!isset($res['error'])) ? true: false;

    }

    public function signin($email, $pwd) {
        $sql = "SELECT * FROM users WHERE email = :email and pwd = :pwd";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':email', $email);
        $sql->bindValue(':pwd', md5($pwd));
        $sql->execute();

        if($sql->rowCount() > 0) {
            $res = $sql->fetch();
            $_SESSION['cLogin'] = $res['id']; 
            return true;
        }
        return false;
    }
};
<?php
require './class/db.class.php';

class Category extends DB {
    public function __construct() {
        parent::__construct();
    }

    public function getList() {
        $array = array();

        $sql = $this->pdo->query("SELECT id, name FROM categories");

        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }
        return $array;
    }

}
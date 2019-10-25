<?php
require './class/db.class.php';

class Ads extends DB {
    public function __construct() {
        parent::__construct();
    }

    public function getList($id = '') {
        $array = array();

        $sql = 'SELECT id, title, description, value, state, 
                (SELECT ads_imgs.url FROM ads_imgs WHERE ads_imgs.id_ads = ads.id AND ads_imgs.ckd = 1 LIMIT 1) as url,
                (SELECT categories.name FROM categories WHERE categories.id = ads.id_category) as category
                FROM ads';
        if(!empty($id)) { $sql .=' WHERE id_user = :id'; };
        $sql = $this->pdo->prepare($sql);
        if(!empty($id)) { $sql->bindValue(':id', $id);};
        $sql->execute();

        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        };

        return $array;

    }

    public function insert($title, $category, $desc, $value, $state) {
        $sql = "INSERT INTO ads (id_user, id_category, title, description, value, state ) VALUES (:id_user, :id_category, :title, :description, :value, :state)";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_user", $_SESSION['cLogin']);
        $sql->bindValue(":id_category", $category);
        $sql->bindValue(":title", $title);
        $sql->bindValue(":description", $desc);
        $sql->bindValue(":value", $value);
        $sql->bindValue(":state", $state);
        $sql->execute();

        if($sql->rowCount() > 0) {
            return true;
        };

        return false;
    }

}
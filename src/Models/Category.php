<?php

namespace Fyyb\Models;

use \Fyyb\Core\Model;

class Category extends Model 
{
    public function getList() 
    {
        $array = array();

        $sql = $this->pdo->query("SELECT id, name FROM categories");

        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        };
        
        return $array;
    }

}
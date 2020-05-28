<?php

namespace App\Models;

use \Fyyb\Support\Sql;
use App\Dao\CategoryDao;

class Category 
{
    public function getList() 
    {
        $array = array();
        
        $sql = new Sql(DB);
        $sql = $sql->query("SELECT `id`, `name` FROM `categories`");

        if ($sql->rowCount() > 0) {
            foreach ($sql->fetchAll() as $cat) {
                $c = new CategoryDao();
                $c->setData($cat);
                $array[] = $c;
            };
        };
        return $array;
    }

}
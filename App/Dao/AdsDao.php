<?php

namespace App\Dao;

use \Fyyb\Support\Model;

class AdsDao extends Model
{
    public function setTitle($title)
    {
        $this->data['title'] = addslashes((trim($title)));
        return; 
    }

    public function setCategory($cat)
    {
        $this->data['category'] = addslashes($cat);
        return;
    }

    public function setDescription($desc)
    {
        $this->data['description'] = addslashes(trim($desc));
        return; 
    }

    public function setValue($v)
    {
        $this->data['value'] = $v;
    }

    public function setValueFormated($v)
    {
        $v = floatval(str_replace(',', '.', str_replace(".", '', $v)));
        $this->setValue($v);
    }
}
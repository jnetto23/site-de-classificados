<?php

namespace Fyyb\Models;

use \Fyyb\Core\Model;

class User extends Model
{
    public function getName()
    {
        return 'João Netto';
    }

    public function getIdade()
    {
        return '27';
    }
}
<?php

namespace Fyyb\Core;

class Model
{
    protected $pdo;

    public function __construct()
    {
        try{
            $this->pdo = new \PDO('mysql:host='. DB['host'] .';dbname=' . DB['dbname'] , DB['user'], DB['password'], array(
                \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", 
                \PDO::FETCH_ASSOC => true
            ));
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        
        } catch(\PDOException $e) {
            // die( print 'Erro ao acessar o Banco de Dados =(');
        };
        return;
    }
}
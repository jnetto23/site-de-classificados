<?php

// Definição de Data e Local
date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_ALL, 'pt-BR');

// Verifica o Ambriente da Aplicação (dev, dev-vhost, prod);
switch (ENVIRONMENT) {
    case 'dev':
    case 'dev-vhost':
		// Definição da BASE URL da Aplicação;
        if (ENVIRONMENT === 'dev') {
            
            define('BASE_URL','');

        } elseif (ENVIRONMENT === 'dev-vhost') {
            
            define('BASE_URL','');
        
        };
        
		// Definição de acesso ao Banco de Dados;
        define('DB', [
            'host'    => '',
            'dbname'  => '', 
            'user'    => '', 
            'password'=> ''
        ]);
        
        // Definição das config de JWT
        define('JWT', [
            'iss' => '', 
			'jti' => '', 
			'key' => '',
			'exp' => ''
        ]);
        break;
        
    case 'prod':
        // Definição da BASE URL da Aplicação;
        define('BASE_URL','');
        
		// Definição de acesso ao Banco de Dados;
        define('DB', [
            'host'    => '',
            'dbname'  => '', 
            'user'    => '', 
            'password'=> ''
        ]);
        
        // Definição das config de JWT
        define('JWT', [
            'iss' => '', 
			'jti' => '', 
			'key' => '',
			'exp' => ''
        ]);
		break;
    };
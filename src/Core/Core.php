<?php

namespace Fyyb\Core;

class Core 
{
    
    public function run()
    {
        // Pega a URL
		$url = '/' . (isset($_GET['url']) ? $_GET['url'] : '');
		$url = (substr($url, -1) === '/') ? substr($url, 0, strlen($url)-1) : $url;
        $url = $this->ckRoutes($url);
        
        $params = array();

        if (!empty($url) && $url != '/') {
			$url = explode('/', $url);
            // Remove a primeira '/' de URL
            array_shift($url);
            // Define o Controller
			$currentController = $url[0].'Controller';
            // Remove o Controller de URL
            array_shift($url);
            // Verifica se foi passado Action
			if (isset($url[0]) && !empty($url[0])) {
                // Define o Action
                $currentAction = $url[0];
                // Remove o Action de URL
				array_shift($url);
			} else {
                // Define o Action
				$currentAction = 'index';
                // Remove o Action de URL
                array_shift($url);
			};
            // Verifica se ainda existe valores em URL
			if (count($url) > 0) {
                // Seta os valores que sobraram como Parametros
				$params = $url;
			};

		} else {
            // Define o Controller padrão
			$currentController = 'HomeController';
            // Define a Action padrão
            $currentAction = 'index';
		};

		$currentController = ucfirst($currentController);
		$prefix = '\Fyyb\Controllers\\';

        if (!file_exists('../src/Controllers/'.$currentController.'.php') ||
            !method_exists($prefix.$currentController, $currentAction)) {

			$currentController = 'NotfoundController';
            $currentAction = 'index';

            $c = new $currentController();
            		
		} else {
			$nc = $prefix.$currentController;
			$c = new $nc();
		};
        

        call_user_func_array(array($c, $currentAction), $params);

    }
    
    private function ckRoutes($url)
    {
        global $routes;
        
        $r = '/notfound/';
        
		foreach($routes as $route => $newUrl) {
            
            // Identificar os argumentos e substituir por RegEx
			$pattern = preg_replace('(\{[a-z0-9]{1,}\})', '([a-z0-9-]{1,})', $route);			
			// Faz o match da URL
			if (preg_match('#^('.$pattern.')*$#i', $url, $matches) === 1) {
				array_shift($matches); array_shift($matches);
				// Pega todos os argumentos para associar
				$itens = array();
				if (preg_match_all('(\{[a-z0-9]{1,}\})', $route, $m)) {
					$itens = preg_replace('(\{|\})', '', $m[0]);
				}
				// Faz a associação
				$arg = array();
				foreach ($matches as $key => $match) {
					$arg[$itens[$key]] = $match;
				}
				// Monta a nova URL
				foreach ($arg as $argkey => $argvalue) {
					$newUrl = str_replace(':'.$argkey, $argvalue, $newUrl);
				}
				$r = $newUrl;
				break;
			}
		}
		return $r;
	}
	
}
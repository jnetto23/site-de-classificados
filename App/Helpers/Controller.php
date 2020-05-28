<?php

namespace App\Helpers;

class Controller
{
    protected function loadView($viewName, $viewData = array())
    {
        extract($viewData);
        if (file_exists('./App/Views/Pages/'.$viewName.'.php')) {
            require './App/Views/Pages/'.$viewName.'.php';
        };

        return false;
	}

    protected function loadViewInTemplate($viewName, $viewData = array(), $template)
    {
        if (file_exists('./App/Views/Templates/'.$template.'.php')) {
            require './App/Views/Templates/'.$template.'.php';
        };

        return false;
	}
}
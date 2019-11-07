<?php

namespace Fyyb\Core;

class Controller
{
    protected function loadView($viewName, $viewData = array())
    {
        extract($viewData);
        if (!file_exists('Views/Pages/'.$viewName.'.php')) {

            echo '<h2>Not Found Page</h2>';

        } else {
            require 'Views/Pages/'.$viewName.'.php';
        }
	}

    protected function loadViewInTemplate($viewName, $viewData = array(), $template)
    {
        if (!file_exists('Views/Templates/'.$template.'.php')) {
            
            echo '<h2>Not Found Page</h2>';

        } else {
            require 'Views/Templates/'.$template.'.php';
        };
	}
}
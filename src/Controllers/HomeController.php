<?php

namespace Fyyb\Controllers;

use \Fyyb\Core\Controller;
use \Fyyb\Models\{
    User,
    Ads,
    Category
};

class HomeController extends Controller
{
    public function index()
    {   
        $user = new User();
        $ads  = new Ads();
        $cat  = new Category();

        $filter = array(
            'category' => '',
            'value' => '',
            'state' => '',
            'img' => ''
        );

        if (isset($_GET['filter']) && !empty($_GET['filter'])) {
            $filter = $_GET['filter'];
        };

        $nAds   = $ads->getTotal($filter);
        $nUsers = $user->getTotal();
        $c      = $cat->getList();
        $p      = (isset($_GET['p']) && !empty($_GET['p'])) ? addslashes($_GET['p']) : 1;
        $qtd    = 5;

        $total_pages = ceil($nAds / $qtd);

        $list = $ads->getList($p, $qtd, $filter);

        $data = array(
            'filter'      => $filter,
            'p'           => $p,
            'qtd'         => $qtd,
            'total_pages' => $total_pages,
            'list'        => $list,
            'nAds'        => $nAds,
            'nUsers'      => $nUsers,
            'c'           => $c
        );
        $this->loadViewInTemplate('home', $data, 'template');
    }

    public function ads($id)
    {
        $a = new Ads();
        $ads = $a->findById($id, 2);
        
        if (empty($ads['id'])) {
            header('Location: '.BASE_URL);
        };

        $data = array(
            'ads' => $ads 
        );

        $this->loadViewInTemplate('anuncio', $data, 'template');

    }
}
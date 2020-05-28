<?php

namespace App\Controllers;

use \Fyyb\Request;
use \Fyyb\Response;

use App\Helpers\Controller;
use App\Models\{
    User,
    Ads,
    Category
};

class HomeController extends Controller
{
    public function index(Request $req, Response $res)
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

        $qs = $req->getQueryString();
        
        $data['filter']         = (isset($qs['filter']) && !empty($qs['filter'])) ? $qs['filter'] : $filter;
        $data['p']              = (isset($qs['p']) && !empty($qs['p'])) ? addslashes($qs['p']) : 1;
        $data['qtd']            = 5;
        $data['list']           = $ads->getList($data['p'], $data['qtd'], $data['filter']);
        $data['nAds']           = $ads->getTotal($filter);
        $data['nUsers']         = $user->getTotal();
        $data['c']              = $cat->getList();
        $data['total_pages']    = ceil($data['nAds'] / $data['qtd']);

        $this->loadViewInTemplate('home', $data, 'template');
    }

    public function show(Request $req, Response $res)
    {
        $id = addslashes($req->getParams()['id']);
        $ads = (new Ads())->findById($id, 2);
        
        if(empty($ads->getId())) {
            $res->redirect(BASE_URL);
        };

        $data = array('ads' => $ads);
        $this->loadViewInTemplate('anuncio', $data, 'template');

    }
}
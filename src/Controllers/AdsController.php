<?php

namespace Fyyb\Controllers;

use \Fyyb\Core\Controller;
use \Fyyb\Models\{
    Ads,
    Category
};

class AdsController extends Controller
{
    public function __construct() 
    {
        if (!isset($_SESSION['cLogin']) || empty($_SESSION['cLogin'])) 
        { 
            header('Location: '.BASE_URL.'login'); 
            exit;
        };
    }
    public function index()
    {   
        
        $ads = new Ads();
        
        $data = array(
            'ads' => $ads->getUserList()
        );

        $this->loadViewInTemplate('meus-anuncios', $data, 'template');
    }

    public function add()
    {   
        $cats = new Category();

        $data = array(
            'cats' => $cats->getList()
        );
        
        if (isset($_POST['title'])) {
            if (
                isset($_POST['title'])    && !empty($_POST['title'])    &&
                isset($_POST['category']) && !empty($_POST['category']) &&
                isset($_POST['desc'])     && !empty($_POST['desc'])     &&
                isset($_POST['value'])    && !empty($_POST['value'])    &&
                isset($_POST['state'])    && !empty($_POST['state'])
            ) {
                $title    = addslashes($_POST['title']);
                $category = addslashes($_POST['category']);
                $desc     = addslashes($_POST['desc']);
                $value    = str_replace(',', '.', str_replace('.', '', addslashes($_POST['value'])));
                $state    = addslashes($_POST['state']);
                
                $imgs = array(
                    'add' => (isset($_POST['add-imgs'])) ? $_POST['add-imgs'] : array(), 
                    'del' => (isset($_POST['del-imgs'])) ? $_POST['del-imgs'] : array(),
                    'ckd' => array(
                        'alter' =>  true,
                        'imgckd' => (isset($_POST['imgckd'])) ? $_POST['imgckd'] : ''
                    )
                );

                $ads = new Ads();
                
                if ($ads->insert($title, $category, $desc, $value, $state, $imgs)) {
                    header('Location: '.BASE_URL.'meus-anuncios');
                
                } else {
                    $data['msg']['class'] = 'warning';
                    $data['msg']['msg']   = 'Ooops! ocorreu um erro, por favor, tente novamente mais tarde.';
                };
                
            } else {                   
                $data['msg']['class'] = 'danger';
                $data['msg']['msg']   = 'Preencha todos os campos!';
            };
        };

        $this->loadViewInTemplate('add-anuncio', $data, 'template');
    }

    public function adit($id)
    {   
        $data = array();
        $this->loadViewInTemplate('', $data, 'template');
    }

    public function del($id)
    {   
        if (isset($id) && !empty($id)) {
            $ads = new Ads();
            $ads->delete($id);
        };
    
        header('Location: '.BASE_URL.'meus-anuncios');
    }
}
<?php

namespace App\Controllers;

use \Fyyb\Request;
use \Fyyb\Response;
use \Fyyb\Support\DataValidation;
use \Fyyb\Support\Token;

use App\Helpers\Controller;
use App\Models\Ads;
use App\Models\Category;
use App\Dao\AdsDao;

class AdsController extends Controller
{
    public function index(Request $req, Response $res)
    {   
        $data['ads'] = (new Ads())->getUserList();
        $this->loadViewInTemplate('meus-anuncios', $data, 'template');
    }

    public function create(Request $req, Response $res)
    {   
        $cats = new Category();
        $data['cats'] = $cats->getList();

        if($req->getMethod() === 'POST') {
            
            $params = $req->getParsedBody();
            $valid = (new DataValidation())->verify($params, ['title', 'category', 'desc', 'value', 'state']);
            
            if(!$valid) {
                $_SESSION['msg']['class'] = 'danger';
                $_SESSION['msg']['msg']   = 'Preencha todos os campos!';
            };

            $title = filter_var($params['title'], FILTER_SANITIZE_SPECIAL_CHARS);
            $category = filter_var($params['category'], FILTER_SANITIZE_SPECIAL_CHARS);
            $desc = filter_var($params['desc'], FILTER_SANITIZE_SPECIAL_CHARS);
            $value = filter_var($params['value'], FILTER_SANITIZE_SPECIAL_CHARS);
            $state = filter_var($params['state'], FILTER_SANITIZE_SPECIAL_CHARS);
            $imgs = array(
                'add' => (isset($params['add-imgs'])) ? $params['add-imgs'] : array(), 
                'del' => (isset($params['del-imgs'])) ? $params['del-imgs'] : array(),
                'ckd' => array(
                    'alter' =>  true,
                    'imgckd' => (isset($params['imgckd'])) ? $params['imgckd'] : ''
                )
            );
            
            if(!$title || !$category || !$desc || !$value || !$state) {
                $_SESSION['msg']['class'] = 'danger';
                $_SESSION['msg']['msg']   = 'Preencha todos os campos!';
            };

            $adsDao = new AdsDao();
            $adsDao->setTitle($title);
            $adsDao->setCategory($category);
            $adsDao->setDescription($desc);
            $adsDao->setValueFormated($value);
            $adsDao->setState($state);
            $adsDao->setImgs($imgs);

            $ads = new Ads();

            if($ads->create($adsDao)) {
                $res->redirect(BASE_URL.'meus-anuncios');
            }
            
            $_SESSION['msg']['class'] = 'warning';
            $_SESSION['msg']['msg']   = 'Ooops! ocorreu um erro, por favor, tente novamente mais tarde.';
        };

        $this->loadViewInTemplate('add-anuncio', $data, 'template');
    }

    public function update(Request $req, Response $res)
    {   
        $id = addslashes($req->getParams()['id']);
        
        $ads = new Ads();
        $cats = new Category();

        $data = array(
            'ads' => $ads->findById($id),
            'cats'=> $cats->getList()
        );

        if($req->getMethod() === 'POST') {
            $params = $req->getParsedBody();
            $valid = (new DataValidation())->verify($params, ['title', 'category', 'desc', 'value', 'state']);
            
            if(!$valid) {
                $_SESSION['msg']['class'] = 'danger';
                $_SESSION['msg']['msg']   = 'Preencha todos os campos!';
            };

            $title = filter_var($params['title'], FILTER_SANITIZE_SPECIAL_CHARS);
            $category = filter_var($params['category'], FILTER_SANITIZE_SPECIAL_CHARS);
            $desc = filter_var($params['desc'], FILTER_SANITIZE_SPECIAL_CHARS);
            $value = filter_var($params['value'], FILTER_SANITIZE_SPECIAL_CHARS);
            $state = filter_var($params['state'], FILTER_SANITIZE_SPECIAL_CHARS);
            $imgs = array(
                'add' => (isset($params['add-imgs'])) ? $params['add-imgs'] : array(), 
                'del' => (isset($params['del-imgs'])) ? $params['del-imgs'] : array(),
                'ckd' => array(
                    'alter' =>  (((isset($params['imgckd'])) ? $params['imgckd'] : '') !== $data['ads']->imgckd()) ? true : false,
                    'imgckd' => (isset($params['imgckd'])) ? $params['imgckd'] : ''
                )
            );

            if(!$title || !$category || !$desc || !$value || !$state) {
                $_SESSION['msg']['class'] = 'danger';
                $_SESSION['msg']['msg']   = 'Preencha todos os campos!';
            };

            $adsDao = new AdsDao();
            $adsDao->setId($id);
            $adsDao->setTitle($title);
            $adsDao->setCategory($category);
            $adsDao->setDescription($desc);
            $adsDao->setValueFormated($value);
            $adsDao->setState($state);
            $adsDao->setImgs($imgs);

            $ads = new Ads();

            if($ads->update($adsDao)) {
                $res->redirect(BASE_URL.'meus-anuncios');
            };
            
            $_SESSION['msg']['class'] = 'warning';
            $_SESSION['msg']['msg']   = 'Ooops! ocorreu um erro, por favor, tente novamente mais tarde.';

        }
        
        if(empty($data['ads']->getId())) {
            $res->redirect(BASE_URL.'meus-anuncios');
        } else {
            $this->loadViewInTemplate('edit-anuncio', $data, 'template');
        };
    }

    public function delete(Request $req, Response $res)
    {   
        if (isset($req->getParams()['id']) && !empty($req->getParams()['id'])) {
            $ads = new Ads();
            $ads->delete($req->getParams()['id']);
        };
        $res->redirect(BASE_URL.'meus-anuncios');
    }
}
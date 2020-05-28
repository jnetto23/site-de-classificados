<?php

namespace App\Models;

use \Fyyb\Support\Sql;
use App\Dao\AdsDao;

class Ads 
{
    private $sql;
    public function __construct()
    {
        $this->sql = new Sql(DB);
    }

    public function getTotal($filter) 
    {
        $filterString = [];
        $bind = [];
        
        if (!empty($filter['category'])) {
            $filterString[] = 'b.id = :id_category';
            $bind[':id_category'] = $filter['category'];
        };

        if (!empty($filter['value'])) {
            $values = explode('-', $filter['value']);
            if($values[1] == 'n') {
                $filterString[] = 'a.value >= :value1';
                $bind[':value1'] = $values[0];
            } else {
                $filterString[] = 'a.value BETWEEN :value1 AND :value2';
                $bind[':value1'] = $values[0];
                $bind[':value2'] = $values[1];
            };
        };

        if (!empty($filter['state'])) {
            $filterString[] = 'a.state = :state';
            $bind[':state'] = $filter['state'];
        };

        if (!empty($filter['img'])) {
            $filterString[] = 'c.ckd = 1';
        };

        $smtp = "SELECT COUNT(a.id) as `c` FROM `ads` a
                    LEFT JOIN `categories` b ON a.`id_category` = b.`id`
                    LEFT JOIN `ads_imgs` c ON a.`id` = c.`id_ads` AND c.`ckd` = 1
                ".((count($filterString) > 0) ? " WHERE ".implode(' AND ', $filterString) : "");

        $sql = $this->sql->query($smtp, $bind);
        return $sql->fetch()['c'];
    }

    public function getList($p, $qtd, $filter) 
    {
        $array = [];
        $filterString = [];
        $bind = [];

        if (!empty($filter['category'])) {
            $filterString[] = 'b.id = :id_category';
            $bind[':id_category'] = $filter['category'];
        };

        if (!empty($filter['value'])) {
            $values = explode('-', $filter['value']);
            if($values[1] == 'n') {
                $filterString[] = 'a.value >= :value1';
                $bind[':value1'] = $values[0].'.00';
            } else {
                $filterString[] = 'a.value BETWEEN :value1 AND :value2';
                $bind[':value1'] = $values[0].'.00';
                $bind[':value2'] = $values[1].'.00';
            };
        };

        if (!empty($filter['state'])) {
            $filterString[] = 'a.state = :state';
            $bind[':state'] = $filter['state'];
        };

        if (!empty($filter['img'])) {
            $filterString[] = 'c.ckd = 1';
        };
        
        $offset = ($p - 1) * $qtd;  

        $smtp = "SELECT 
                    a.`id` as `id`, 
                    a.`title` as `title`, 
                    a.`description` as `description`, 
                    a.`value` as `value`, 
                    a.`state` as `state`,
                    b.`name` as `category`, 
                    c.`url` as `img`
                FROM `ads` a
                LEFT JOIN `categories` b ON a.`id_category` = b.`id`
                LEFT JOIN `ads_imgs` c ON a.`id` = c.`id_ads` AND c.`ckd` = 1"
                .((count($filterString) > 0) ? " WHERE ".implode(' AND ', $filterString) : "")
                ." ORDER BY a.`id` DESC LIMIT $offset, $qtd";

        $sql = $this->sql->query($smtp, $bind);
        if ($sql->rowCount() > 0) {
            foreach($sql->fetchAll() as $ads) {
                $adsDao = new AdsDao();
                $adsDao->setData($ads);
                $array[] = $adsDao;
            }
        }
        
        return $array;
    }

    public function getUserList() 
    {
        $array = array();

        $smtp = "SELECT 
                    a.`id` as `id`, 
                    a.`title` as `title`, 
                    a.`description` as `description`, 
                    a.`value` as `value`, 
                    a.`state` as `state`,
                    b.`name` as `category`, 
                    c.`url` as `img`
                FROM `ads` a
                LEFT JOIN `categories` b ON a.`id_category` = b.`id`
                LEFT JOIN `ads_imgs` c ON a.`id` = c.`id_ads` AND c.`ckd` = 1
                WHERE a.`id_user` = :id ORDER BY a.`id`";

        $sql = $this->sql->query($smtp, [':id' => $_SESSION['User']['id']]);

        if ($sql->rowCount() > 0) {
            foreach($sql->fetchAll() as $ads) {
                $adsDao = new AdsDao();
                $adsDao->setData($ads);
                $array[] = $adsDao;
            }
        }

        return $array;

    }

    public function findById($id, $type=1) 
    {
        $array = array();
        if ($type === 1) {
            $owner = $_SESSION['User']['id'];
            $smtp = "CALL sp_ads_findById(:id, $owner)";
        } else {
            $smtp = "CALL sp_ads_findAllById(:id)";
        };
        
        $sql = $this->sql->query($smtp, [':id' => $id]);
        if ($sql->rowCount() > 0) {
            $ads = $sql->fetch();
            $adsDao = new AdsDao();
            $adsDao->setData($ads);
            $array = $adsDao;
        }
        return $array;
    }

    public function create(adsDao $ads) 
    {
        // Tratando as imagens
        $ckd_img = ($ads->getImgs()['ckd']['alter']) ? $ads->getImgs()['ckd']['imgckd'] : '';
        
        $formatAddImgs = $this->formatAdsImgs($ads->getImgs()['add'], $ckd_img);
        $add_imgs = $formatAddImgs['add'];
        
        if ($formatAddImgs['ckd'] !== '') {$ckd_img = $formatAddImgs['ckd'];};
        
        $sql = $this->sql->query("CALL sp_ads_save(
                        :id_user, 
                        :id_category, 
                        :title, 
                        :description, 
                        :value, 
                        :state, 
                        :add_imgs, 
                        :ckd_img
                    )", [
                        ":id_user"      => $_SESSION['User']['id'],
                        ":id_category"  => $ads->getCategory(),
                        ":title"        => $ads->getTitle(),
                        ":description"  => $ads->getDescription(),
                        ":value"        => $ads->getValue(),
                        ":state"        => $ads->getState(),
                        ":add_imgs"     => $add_imgs,
                        ":ckd_img"      => $ckd_img
                    ]);
        
        return ($sql->rowCount() > 0);
    }
        
    public function update(adsDao $ads) 
    {
        
        // Tratando as imagens
        $ckd_img = ($ads->getImgs()['ckd']['alter']) ? $ads->getImgs()['ckd']['imgckd'] : '';
        
        $del_imgs = (count($ads->getImgs()['del']) > 0) ? $this->deleteFileImgs($ads->getImgs()['del']) : '';
        $formatAddImgs = $this->formatAdsImgs($ads->getImgs()['add'], $ckd_img);
        $add_imgs = $formatAddImgs['add'];
        
        if ($formatAddImgs['ckd'] !== '') {$ckd_img = $formatAddImgs['ckd'];};

        $owner = $_SESSION['User']['id'];
        $sql = $this->sql->query("CALL sp_ads_edit(
                        :id, 
                        :id_category, 
                        :title, 
                        :description, 
                        :value, 
                        :state, 
                        :del_imgs, 
                        :add_imgs, 
                        :ckd_img,
                        $owner
                    )",[
                        ':id'         => $ads->getId(),
                        ':title'        => $ads->getTitle(),
                        ':id_category'  => $ads->getCategory(),
                        ':description'  => $ads->getDescription(),
                        ':value'        => $ads->getValue(),
                        ':state'        => $ads->getState(),
                        ':del_imgs'     => $del_imgs,
                        ':add_imgs'     => $add_imgs,
                        ':ckd_img'      => $ckd_img
                    ]);

        
        return ($sql->rowCount() > 0);
    }

    public function delete($id) 
    {
        $owner = $_SESSION['User']['id'];
        $sql = $this->sql->query("CALL sp_ads_del(:id, $owner)", [':id' => $id]);

        if ($sql->rowCount() > 0) {
            $sql = $sql->fetch()['imgs'];
            $this->deleteFileImgs(explode(',',$sql));
        };
        return;
    }

    private function formatAdsImgs($imgs, $ckd) 
    {
        $imgArray = array();
        $imgCkd = '';

        foreach($imgs as $img) {
            // Pegando os dados da img
            list($name, $tipo, $dados) = explode(';', $img);
            
            // Isolando apenas o nome da imagem
            list(, $name) = explode(':', $name);
                        
            // Isolando apenas o tipo da imagem
            list(, $tipo) = explode(':', $tipo);

            // Isolando apenas os dados da imagem
            list(, $dados) = explode(',', $dados);

            // Verificando o ckd
            $verifyCkd = (trim($name) == trim($ckd)) ? '1' : $ckd;

            // Verificando o tipo da imagem
            if (in_array($tipo, array('image/jpeg', 'image/png'))) {
                
                // Criando Nome Unico
                $name = md5($name . uniqid(time() . rand(0,9999)) . time() . rand(0,9999)).'.jpg';
                
                // Seta o ckd
                if ($verifyCkd === '1') {$imgCkd = $name;};

                // Adiciona a imagem no array de imagens
                $imgArray[] = $name;

                // Convertendo base64 para imagem
                $dados = base64_decode($dados);

                $imgName = VIEWS['ASSETS']."img/ads/".$name;
                // Salva a Imagem versão original
                file_put_contents($imgName, $dados);

                // Redimencionando a imagem
                list($width_orig, $height_orig) = getimagesize($imgName);
                
                $ratio = $width_orig / $height_orig;
                $width = 500; 
                $height = 500;

                if ($width / $height > $ratio) {
                    $width = $height * $ratio;
                
                } else {
                    $height = $width / $ratio;
                };

                $img = imagecreatetruecolor($width, $height);
                
                if ($tipo === 'image/jpeg') {
                    $orig = imagecreatefromjpeg($imgName);
                
                } elseif ($tipo === 'image/png') {
                    $orig = imagecreatefrompng($imgName);
                };

                imagecopyresampled($img, $orig, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
                imagejpeg($img, $imgName, 100);
            }
        };

        $array = array (
            'add' => implode(',', $imgArray),
            'ckd' => $imgCkd
        );

        return $array;

    }
    
    private function deleteFileImgs($imgs) 
    {
        foreach($imgs as $img) {
            unlink(VIEWS['ASSETS']."img/ads/".$img);
        };
        
        return implode(',', $imgs);
    }
}
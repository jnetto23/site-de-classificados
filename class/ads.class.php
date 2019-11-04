<?php
include_once './class/db.class.php';

class Ads extends DB {
    public function __construct() {
        parent::__construct();
    }

    public function getTotal() {
        $ads = $this->pdo->query('SELECT COUNT(id) as c FROM ads');
        $ads = $ads->fetch()['c'];
        return $ads;
    }

    public function getList($p, $qtd) {
        $array = array();

        $offset = ($p - 1) * $qtd;  

        $sql = "SELECT 
            a.id as id, a.title as title, a.description as description, a.value as value, a.state as state, 
            b.name as category, 
            c.url as img
        FROM ads a
        LEFT JOIN categories b ON a.id_category = b.id
        LEFT JOIN ads_imgs c ON a.id = c.id_ads AND c.ckd = 1
        ORDER BY a.id DESC LIMIT $offset, $qtd";

        $sql = $this->pdo->prepare($sql);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        };

        return $array;

    }

    public function getUserList() {
        $array = array();

        $sql = 'SELECT 
            a.id as id, a.title as title, a.description as description, a.value as value, a.state as state, 
            b.name as category, 
            c.url as img
        FROM ads a
        LEFT JOIN categories b ON a.id_category = b.id
        LEFT JOIN ads_imgs c ON a.id = c.id_ads AND c.ckd = 1
        WHERE a.id_user = :id ORDER BY a.id';

        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $_SESSION['cLogin']);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        };

        return $array;

    }

    public function findById($id) {
        $array = array();
        $sql = 'CALL sp_ads_findById(:id)';
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $array = $sql->fetch();
        };
        return $array;
    }

    public function insert($title, $category, $desc, $value, $state, $imgs) {
        // Tratando as imagens
        $ckd_img = ($imgs['ckd']['alter']) ? $imgs['ckd']['imgckd'] : '';
        
        $formatAddImgs = $this->formatAdsImgs($imgs['add'], $ckd_img);
        $add_imgs = $formatAddImgs['add'];
        
        if($formatAddImgs['ckd'] !== '') {$ckd_img = $formatAddImgs['ckd'];};
        
        $sql = "CALL sp_ads_save(:id_user, :id_category, :title, :description, :value, :state, :add_imgs, :ckd_img)";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_user", $_SESSION['cLogin']);
        $sql->bindValue(":id_category", $category);
        $sql->bindValue(":title", $title);
        $sql->bindValue(":description", $desc);
        $sql->bindValue(":value", $value);
        $sql->bindValue(":state", $state);
        $sql->bindValue(":add_imgs", $add_imgs);
        $sql->bindValue(":ckd_img", $ckd_img);
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            return true;
        };
        
        return false;
    }
        
    public function edit($id, $title, $category, $desc, $value, $state, $imgs) {
        
        // Tratando as imagens
        $ckd_img = ($imgs['ckd']['alter']) ? $imgs['ckd']['imgckd'] : '';
        
        
        $del_imgs = (count($imgs['del']) > 0) ? $this->deleteFileImgs($imgs['del']) : '';
        $formatAddImgs = $this->formatAdsImgs($imgs['add'], $ckd_img);
        $add_imgs = $formatAddImgs['add'];
        
        if($formatAddImgs['ckd'] !== '') {$ckd_img = $formatAddImgs['ckd'];};

        $sql = "CALL sp_ads_edit(:id, :id_category, :title, :description, :value, :state, :del_imgs, :add_imgs, :ckd_img)";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->bindValue(':title', $title);
        $sql->bindValue(':id_category', $category);
        $sql->bindValue(':description', $desc);
        $sql->bindValue(':value', $value);
        $sql->bindValue(':state', $state);
        $sql->bindValue(':del_imgs', $del_imgs);
        $sql->bindValue(':add_imgs', $add_imgs);
        $sql->bindValue(':ckd_img', $ckd_img);
        $sql->execute();

        if($sql->rowCount() > 0) {
            return true;
        };

        return false;
    }

    public function delete($id) {
        $sql = "CALL sp_ads_del(:id)";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $sql = $sql->fetch()['imgs'];
            $this->deleteFileImgs(explode(',',$sql));
        };
        return;
    }

    private function formatAdsImgs($imgs, $ckd) {
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
            $ckd = ($name === $ckd) ? '1' : '0';

            // Verificando o tipo da imagem
            if(in_array($tipo, array('image/jpeg', 'image/png'))) {
                
                // Criando Nome Unico
                $name = md5($name . uniqid(time() . rand(0,9999)) . time() . rand(0,9999)).'.jpg';
                
                // Seta o ckd
                if($ckd === '1') { 
                    $imgCkd = $name;
                };
                // Adiciona a imagem no array de imagens
                $imgArray[] = $name;

                // Convertendo base64 para imagem
                $dados = base64_decode($dados);

                // Salva a Imagem versão original
                file_put_contents("./assets/img/ads/".$name, $dados);

                // Redimencionando a imagem
                list($width_orig, $height_orig) = getimagesize("./assets/img/ads/".$name);
                
                $ratio = $width_orig / $height_orig;
                $width = 500; 
                $height = 500;

                if($width / $height > $ratio) {
                    $width = $height * $ratio;
                } else {
                    $height = $width / $ratio;
                };

                $img = imagecreatetruecolor($width, $height);
                if($tipo === 'image/jpeg') {
                    $orig = imagecreatefromjpeg("./assets/img/ads/".$name);
                } elseif($tipo === 'image/png') {
                    $orig = imagecreatefrompng("./assets/img/ads/".$name);
                };

                imagecopyresampled($img, $orig, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
                imagejpeg($img, "./assets/img/ads/".$name, 100);
            }
        };

        $array = array (
            'add' => implode(',', $imgArray),
            'ckd' => $imgCkd
        );

        return $array;

    }
    
    private function deleteFileImgs($imgs) {
        foreach($imgs as $img) {
            unlink("./assets/img/ads/".$img);
        };
        return implode(',', $imgs);
    }
}
<?php require './pages/header.php'; ?>
<?php 
    if(!isset($_SESSION['cLogin']) || empty($_SESSION['cLogin'])) { 
        header('Location: ./login'); 
        exit;
    };

    if(!isset($_GET['id']) || empty($_GET['id'])) {
        header('Location: ./meus-anuncios');
        exit;
    };

    require './class/ads.class.php';
    require './class/category.class.php';

    $ads = new Ads();
    $ads = $ads->findById($_GET['id']);
    if(count($ads) === 0) {
        header('Location: ./meus-anuncios');
    };
?>
    <main class="container mt-2">
        <form id="form-edit-ads" method='POST' enctype="multipart/form-data">
            <span class="text-center text-uppercase h5">Editar Anúncio</span>
            
            <hr class="divider">
            <?php
                if(isset($_POST['title'])) {
                                        
                    if(
                        isset($_POST['title']) && !empty($_POST['title']) &&
                        isset($_POST['category']) && !empty($_POST['category']) &&
                        isset($_POST['desc']) && !empty($_POST['desc']) &&
                        isset($_POST['value']) && !empty($_POST['value']) &&
                        isset($_POST['state']) && !empty($_POST['state'])
                    ) {
                        $id = $ads['id'];
                        $title = addslashes($_POST['title']);
                        $category = addslashes($_POST['category']);
                        $desc = addslashes($_POST['desc']);
                        $value = addslashes($_POST['value']);
                        $value = str_replace(',', '.', str_replace('.', '', $value)); 
                        $state = addslashes($_POST['state']);
                           
                        
                        $imgs = array(
                            'add' => (isset($_POST['add-imgs'])) ? $_POST['add-imgs'] : array(), 
                            'del' => (isset($_POST['del-imgs'])) ? $_POST['del-imgs'] : array(),
                            'ckd' => array(
                                'alter' =>  (((isset($_POST['imgckd'])) ? $_POST['imgckd'] : '') !== $ads['imgckd']) ? true : false,
                                'imgckd' => (isset($_POST['imgckd'])) ? $_POST['imgckd'] : ''
                            )
                        );
                        
                        $a = new Ads();
                        
                        if($a->edit($id, $title, $category, $desc, $value, $state, $imgs)) {
                            header('Location: ./meus-anuncios');
                        } else {
                            ?>
                                <div class="alert alert-warning text-center">
                                    Ooops! ocorreu um erro, por favor, tente novamente mais tarde.
                                </div>
                            <?php
                        }
                    } else {                   
                        ?>
                            <div class="alert alert-danger text-center">
                                Preencha todos os campos!
                            </div>
                        <?php
                    }
                }
            ?>
            <div class="d-flex flex-wrap w-100">
                <div class="col-12 col-md-6 d-flex flex-column">
                    <div class="form-group">
                        <label class="mb-1" for="title">Titulo:</label>
                        <input class="form-control" type="text" name="title" placeholder="Titulo do Anúncio" value="<?php echo $ads['title'];?>" required >
                    </div>

                    <div class="form-group">
                        <label class="mb-1" for="category">Categoria:</label>
                        <select class="form-control" type="text" name="category"required> 
                            
                            <?php 
                                $c = new Category();
                                $cats = $c->getList();
                                foreach($cats as $cat):
                            ?>
                            <option value="<?php echo $cat['id']?>" <?php echo ($ads['category'] === $cat['id']) ? 'selected' : '';?>><?php echo $cat['name']?></option>
                            <?php endforeach; ?>
                            
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="mb-1" for="desc">Descrição:</label>
                        <textarea class="form-control" type="text" name="desc" rows="3" required><?php echo $ads['description'];?> </textarea>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-6">
                                <label class="mb-1" for="state">Condição:</label>
                                <select class="form-control" type="text" name="state"required> 
                                    <option value="N" <?php echo ($ads['state'] === 'N') ? 'selected' : ''; ?>> Novo </option>    
                                    <option value="U" <?php echo ($ads['state'] === 'U') ? 'selected' : ''; ?>> Usado </option>    
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="mb-1" for="value">Valor:</label>
                                <input class="form-control text-right" type="text" name="value" placeholder="0,00" value="<?php echo number_format($ads['value'], 2, ',', '.');?>" required>                
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 col-md-6">
                    <div class="form-group">
                    
                        <label class="mb-1" for="img">Fotos do Anúncio:</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name='img[]' multiple accept="image/png, image/jpeg">
                            <label class="custom-file-label" for="img">Escolher Fotos</label>
                        </div>
                        
                        <div id="card-imgs" class="card mt-3 d-none">
                            <div class="card-header text-center"> <span class="">Fotos do Anuncio</span></div>
                            <div class="card-body p-1">
                                <div id="input-imgs" class="d-none"></div>
                                <div id="radio-imgs" class="d-flex flex-wrap">
                                    <?php if(strlen($ads['imgs']) > 0) : ?> 
                                        <?php foreach(explode(',', $ads['imgs']) as $img) : ?>
                                            <div class="img-product d-flex flex-column col-12 col-md-6 col-lg-4">
                                                <input id="<?php echo $img;?>" type="radio" name=imgckd value="<?php echo $img;?>" <?php echo ($img === $ads['imgckd']) ? 'checked' : ''?>>
                                                <label for="<?php echo $img;?>" class="d-flex flex-column">
                                                    <img data-origin="db" src="./assets/img/ads/<?php echo $img;?>" alt="<?php echo $img;?>">
                                                    <button type="button" class="btn btn-danger m-2" onclick="removeAdsImg(this)">Excluir</button>    
                                                </label>
                                            </div>
                                        <?php endforeach;?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-row mt-2">
                    <div class="col-12 col-md-6 mb-3">
                        <a href="./meus-anuncios" role="button" class="btn btn-danger w-100">Cancelar</a>
                    </div>
                    <div class="col-12 col-md-6">
                        <input type="submit" class="btn btn-primary w-100" value="Salvar">
                    </div>
                </div>
            </div>
        </form>
    </main>
<?php require './pages/footer.php'; ?>
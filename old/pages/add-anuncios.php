<?php require './pages/header.php'; ?>
<?php 
    if(!isset($_SESSION['cLogin']) || empty($_SESSION['cLogin'])) { 
        header('Location: ./login'); 
        exit;
    };
    require './class/category.class.php';
?>
    <main role="main" class="container mt-2 flex-shrink-0 mb-5">
        <form id="form-add-ads" method='POST' enctype="multipart/form-data">
            <span class="text-center text-uppercase h5">Adicionar Novo Anúncio</span>
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
                        $title = addslashes($_POST['title']);
                        $category = addslashes($_POST['category']);
                        $desc = addslashes($_POST['desc']);
                        $value = addslashes($_POST['value']);
                        $state = addslashes($_POST['state']);
                        
                        $value = str_replace(',', '.', str_replace('.', '', $value)); 

                        $imgs = array(
                            'add' => (isset($_POST['add-imgs'])) ? $_POST['add-imgs'] : array(), 
                            'del' => (isset($_POST['del-imgs'])) ? $_POST['del-imgs'] : array(),
                            'ckd' => array(
                                'alter' =>  true,
                                'imgckd' => (isset($_POST['imgckd'])) ? $_POST['imgckd'] : ''
                            )
                        );

                        require './class/ads.class.php';
                        $ads = new Ads();
                        
                        if($ads->insert($title, $category, $desc, $value, $state, $imgs)) {
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
                        <input class="form-control" type="text" name="title" placeholder="Titulo do Anúncio" required autofocus>
                    </div>

                    <div class="form-group">
                        <label class="mb-1" for="category">Categoria:</label>
                        <select class="form-control" type="text" name="category" required> 
                        <option value="-1" class="select-title"> Selecione uma categoria </option>
                            <?php 
                                $c = new Category();
                                $cats = $c->getList();
                                foreach($cats as $cat):
                            ?>
                            <option value="<?php echo $cat['id']?>"><?php echo $cat['name']?></option>
                            <?php endforeach; ?>
                            
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="mb-1" for="desc">Descrição:</label>
                        <textarea class="form-control" type="text" name="desc" rows="3" placeholder="Insira uma breve descrição" required></textarea>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-6">
                                <label class="mb-1" for="state">Condição:</label>
                                <select class="form-control" type="text" name="state" required> 
                                    <option value="-1" class="select-title"> Informe a condição </option>
                                    <option value="N"> Novo </option>    
                                    <option value="U"> Usado </option>    
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="mb-1" for="value">Valor:</label>
                                <input class="form-control text-right" type="text" name="value" placeholder="0,00" pattern="\.\,\[0-9]+$" required>                
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 col-md-6">
                    <div class="form-group">
                    
                        <label class="mb-1" for="img">Fotos do Anúncio:</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" multiple accept="image/png, image/jpeg">
                            <label class="custom-file-label" for="img">Escolher Fotos</label>
                        </div>
                        
                        <div id="card-imgs" class="card mt-3 d-none">
                            <div class="card-header text-center"> <span class="">Fotos do Anuncio</span></div>
                            <div class="card-body p-1">
                                <div id="input-imgs" class="d-none"></div>
                                <div id="radio-imgs" class="d-flex flex-wrap"></div>
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
                        <input type="submit" class="btn btn-primary w-100" value="Adicionar">
                    </div>
                </div>
            </div>
        </form>

    </main>
<?php require './pages/footer.php'; ?>
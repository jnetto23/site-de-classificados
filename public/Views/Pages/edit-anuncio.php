<div class="container">
    <form id="form-edit-ads" method='POST' enctype="multipart/form-data">
        <span class="text-center text-uppercase h5">Editar Anúncio</span>
        <hr class="divider">
        <?php if(isset($msg)): ?>
        <div class="alert alert-<?php echo $msg['class'];?> text-center">
            <?php echo $msg['msg'];?>                    
        </div>
        <?php endif;?>    
        <div class="d-flex flex-wrap w-100">
            <div class="col-12 col-md-6 d-flex flex-column">
                <div class="form-group">
                    <label class="mb-1" for="title">Titulo:</label>
                    <input class="form-control" type="text" name="title" placeholder="Titulo do Anúncio" value="<?php echo $ads['title'];?>" required >
                </div>
                <div class="form-group">
                    <label class="mb-1" for="category">Categoria:</label>
                    <select class="form-control" type="text" name="category"required> 
                        <?php foreach($cats as $cat):?>
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
                                        <img 
                                            data-origin="db" 
                                            src="<?php echo BASE_URL;?>Assets/img/ads/<?php echo $img;?>"
                                            onerror="this.src='<?php echo BASE_URL;?>Assets/img/ads/default.png';" 
                                            alt="<?php echo $img;?>"
                                        >
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
                    <a href="<?php echo BASE_URL; ?>meus-anuncios" role="button" class="btn btn-danger w-100">Cancelar</a>
                </div>
                <div class="col-12 col-md-6">
                    <input type="submit" class="btn btn-primary w-100" value="Salvar">
                </div>
            </div>
        </div>
    </form>
</div>
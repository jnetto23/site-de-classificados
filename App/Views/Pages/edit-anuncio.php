<main>
<div class="container">
    <form id="form-edit-ads" method='POST' enctype="multipart/form-data">
        <span class="text-center text-uppercase h5">Editar Anúncio</span>
        <hr class="divider">
        <?php if(isset($_SESSION['msg'])): ?>
        <?php $msg = $_SESSION['msg']; unset($_SESSION['msg']);?>
        <div class="alert alert-<?php echo $msg['class'];?> text-center">
            <?php echo $msg['msg'];?>                    
        </div>
        <?php endif;?>    
        <div class="d-flex flex-wrap w-100">
            <div class="col-12 col-md-6 d-flex flex-column">
                <div class="form-group">
                    <label class="mb-1" for="title">Titulo:</label>
                    <input class="form-control" type="text" name="title" placeholder="Titulo do Anúncio" value="<?=$ads->getTitle();?>" required >
                </div>
                <div class="form-group">
                    <label class="mb-1" for="category">Categoria:</label>
                    <select class="form-control" type="text" name="category"required> 
                        <?php foreach($cats as $cat):?>
                        <option 
                            value="<?=$cat->getId()?>" 
                            <?=($ads->getCategory() === $cat->getId()) ? 'selected' : '';?>
                        >
                            <?=$cat->getName();?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="mb-1" for="desc">Descrição:</label>
                    <textarea class="form-control" type="text" name="desc" rows="3" required><?=$ads->getDescription();?></textarea>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-6">
                            <label class="mb-1" for="state">Condição:</label>
                            <select class="form-control" type="text" name="state"required> 
                                <option value="N" <?=($ads->getState() === 'N') ? 'selected' : ''; ?>> Novo </option>    
                                <option value="U" <?=($ads->getState() === 'U') ? 'selected' : ''; ?>> Usado </option>    
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="mb-1" for="value">Valor:</label>
                            <input class="form-control text-right" name="value" type="text" maxlength="13" autocomplete="off" placeholder="0,00" value="<?=number_format($ads->getValue(), 2, ',', '.');?>" required>                
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
                                <?php if(strlen($ads->getImgs()) > 0) : ?> 
                                <?php foreach(explode(',', $ads->getImgs()) as $img) : ?>
                                <div class="img-product d-flex flex-column col-12 col-md-6 col-lg-4">
                                    <input 
                                        id="<?=$img;?>" 
                                        type="radio" 
                                        name=imgckd 
                                        value="<?=$img;?>" 
                                        <?=($img === $ads->getImgckd()) ? 'checked' : ''?>
                                    >
                                    <label for="<?= $img;?>" class="d-flex flex-column">
                                        <img 
                                            data-origin="db" 
                                            src="<?= VIEWS['ASSETS']?>img/ads/<?=$img;?>"
                                            onerror="this.src='<?=VIEWS['ASSETS']?>img/ads/default.png';" 
                                            alt="<?=$img;?>"
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
                    <a href="<?=BASE_URL?>meus-anuncios" role="button" class="btn btn-danger w-100">Cancelar</a>
                </div>
                <div class="col-12 col-md-6">
                    <input type="submit" class="btn btn-primary w-100" value="Salvar">
                </div>
            </div>
        </div>
    </form>
</div>
</main>
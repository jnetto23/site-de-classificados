<main>
<div class="jumbotron">
    <div class="container">
        <h2>Nós temos hoje <?php echo $nAds;?> anúncios.</h2>
        <p>E mais de <?php echo $nUsers;?> usuários cadastrados.</p>
    </div>
</div>
<div class="container content">
    <div class="row">
        <div class="col-12 col-md-4 col-lg-3 mb-5">
            <h5>Pesquisa Avançada</h5>

            <form method="GET">
                <div class="form-group">
                    <label for="category">Categoria:</label>
                    <select class="form-control" id="category" name="filter[category]">
                        <option></option>
                        <?php foreach($c as $category):?>
                            <option value="<?=$category->getId();?>" <?=($filter['category'] == $category->getId()) ? 'selected' : ''?>>
                                <?=$category->getName();?>
                            </option>
                        <?php endforeach;?>                                
                    </select>
                </div>
                <div class="form-group">
                    <label for="value">Valor:</label>
                    <select name="filter[value]" id="value" class="form-control">
                        <option></option>
                        <option value="0-50" <?php echo ($filter['value'] == '0-50') ? 'selected' : ''?>>R$ 0,00 - 50,00</option>
                        <option value="51-100" <?php echo ($filter['value'] == '51-100') ? 'selected' : ''?>>R$ 51,00 - 100,00</option>
                        <option value="101-200" <?php echo ($filter['value'] == '101-200') ? 'selected' : ''?>>R$ 101,00 - 200,00</option>
                        <option value="201-300" <?php echo ($filter['value'] == '201-300') ? 'selected' : ''?>>R$ 201,00 - 300,00</option>
                        <option value="301-400" <?php echo ($filter['value'] == '301-400') ? 'selected' : ''?>>R$ 301,00 - 400,00</option>
                        <option value="401-n" <?php echo ($filter['value'] == '401-n') ? 'selected' : ''?>>Acima de R$ 400,00</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="state">Condição:</label>
                    <select class="form-control" id="state" name="filter[state]">
                        <option></option>
                        <option value="N" <?php echo ($filter['state'] == 'N') ? 'selected' : ''?>>Novo</option>
                        <option value="U" <?php echo ($filter['state'] == 'U') ? 'selected' : ''?>>Usado</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="img">Imagem:</label>
                    <select name="filter[img]" id="img" class="form-control">
                        <option></option>
                        <option value="1" <?php echo ($filter['img'] == 1) ? 'selected' : '';?>>Somente com imagem</option>
                    </select>
                </div>
                <div class="text-center">
                    <a href="./" role="buttom" class="btn btn-danger">Limpar</a>
                    <input type="submit" class="btn btn-primary" value="Filtrar">
                </div>
            </form>
        </div>
        <div class="col-12 col-md-8 col-lg-9">
            <h5>Últimos Anúncios</h5>
            <div class="list-group h-100">
                <div class="table-responsive d-flex flex-column justify-content-between h-100">
                    <ul class="list-group list-group-flush striped">
                        <?php foreach($list as $ad): ?>
                        <a href="./anuncio/<?=$ad->getId()?>" class="index-table-list list-group-item list-group-item-action d-flex">
                            <div class="col-3 col-md-1 img d-flex justify-content-center">
                                <img 
                                    src="<?=VIEWS['ASSETS']?>img/ads/<?=($ad->getImg()) ? $ad->getImg() : 'default.png';?>" 
                                    onerror="this.src='<?=VIEWS['ASSETS']?>img/ads/default.png';"
                                    alt="<?=$ad->getTitle()?>" 
                                    width="40" 
                                    height="40"
                                >
                            </div>
                            <div class="col d-flex flex-wrap justify-content-between align-items-center p-1">
                                <div class="details d-flex flex-column mb-1 ">
                                    <span><?=$ad->getTitle()?></span>
                                    <small><?=$ad->getCategory()?></small>
                                </div>
                                <div class="price">
                                    <span class="text-center">R$ <?=number_format($ad->getvalue(), 2, ",", ".");?></span>
                                </div>
                            </div>
                        </a>
                        <?php endforeach;?>
                    </ul>
                    <nav class="my-2" aria-label="Navegação de Anúncios">
                        <ul class="pagination justify-content-center">
                            <?php for($i=1; $i <= $total_pages; $i++):?>
                                <li class="page-item <?= ($i == $p) ? 'active' : '';?>">
                                    <a class="page-link" href="./?<?php 
                                        $w = $_GET;
                                        $w['p'] = $i;
                                        echo http_build_query($w);
                                    ?>">
                                        <?=$i;?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
</main>
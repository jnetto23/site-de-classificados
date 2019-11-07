<div class="container content mt-3">
    <div class="row">
        <div class="col-12 col-md-4">
            <div id="carousel-imgs" class="carousel slide carousel-fade" data-ride="carousel">
                <?php if(empty($ads['imgs'])):?>
                    <img class="d-block w-100" src="<?php echo BASE_URL;?>Assets/img/ads/default.png" alt="Default img">
                <?php elseif(count(explode(',', $ads['imgs'])) === 1):?>
                    <img 
                        class="d-block w-100" 
                        src="<?php echo BASE_URL;?>Assets/img/ads/<?php echo $ads['imgs']?>" 
                        onerror="this.src='<?php echo BASE_URL;?>Assets/img/ads/default.png';"
                        alt="<?php echo $ads['imgs']?>"
                    >
                <?php else:?>
                    <ol class="carousel-indicators">
                        <?php for($i=0;$i < count(explode(',', $ads['imgs'])); $i++):?>
                            <li data-target="#carousel-imgs" data-slide-to="<?php echo $i?>" class="<?php echo ($i === 0) ? 'active' :''?>"></li>
                        <?php endfor; ?>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img 
                                class="d-block w-100" 
                                src="<?php echo BASE_URL;?>Assets/img/ads/<?php echo $ads['imgckd']?>"
                                onerror="this.src='<?php echo BASE_URL;?>Assets/img/ads/default.png';"
                                alt="<?php echo $ads['imgckd']?>"
                            >
                        </div>
                        <?php foreach(explode(',', $ads['imgs']) as $img): ?>
                            <?php if($img !== $ads['imgckd']):?>
                                <div class="carousel-item">
                                    <img 
                                        class="d-block w-100" 
                                        src="<?php echo BASE_URL;?>Assets/img/ads/<?php echo $img?>" 
                                        onerror="this.src='<?php echo BASE_URL;?>Assets/img/ads/default.png';"
                                        alt="<?php echo $img?>"
                                    >
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <a class="carousel-control-prev" href="#carousel-imgs" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Anterior</span>
                    </a>
                    <a class="carousel-control-next" href="#carousel-imgs" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Próximo</span>
                    </a>
                <?php endif;?>
            </div>
        </div>
        <div class="col-12 col-md-8 d-flex flex-column">
            <div class="ads-info d-flex flex-column h-100">
                <h3><?php echo $ads['title'];?></h3>
                <hr class="divider my-2"/>
                <div class="d-block mb-3">
                    <a class="px-2 py-1 font-italic" style="background-color:#98c3f19c; border-radius:3px" 
                    href="<?php echo BASE_URL;?>?<?php 
                    $a['filter']['category'] = $ads['id_category'];
                    echo http_build_query($a);
                    ?>">
                        <small style="vertical-align: text-top;">#<?php echo $ads['name_category'];?></small>
                    </a>
                </div>
                <div class="d-flex flex-column justify-content-between h-100">
                    <div class="ads-description">
                        <small class="d-block font-weight-bold font-italic">Descrição:</small>
                        <p class="text-justify"><?php echo $ads['description'];?></p>
                    </div>
                    <div class="ads-details d-flex">
                        <div class="cond mr-md-3">
                            <small class="d-block font-weight-bold font-italic">Conservação:</small>
                            <span><?php echo ($ads['state'] === 'N')?'Novo':'Usado';?></span>
                        </div>
                        <div class="vl">
                            <small class="d-block font-weight-bold font-italic">Valor:</small>
                            <span>R$ <?php echo number_format($ads['value'], 2, ',', '.');?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="user-info">
                <hr class="divider mb-1"/>
                <small class="d-block font-weight-bold font-italic">Anúnciante:</small>
                <span class="d-block"><?php echo $ads['name_user']?></span>
                <small><a href="mailto:<?php echo $ads['email_user']?>"><?php echo $ads['email_user']?></a></small>
            </div>
        </div>
    </div>
</div>

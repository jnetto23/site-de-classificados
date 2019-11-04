<?php 
    require './pages/header.php';
    require './class/ads.class.php';
    require './class/user.class.php';

    $ads = new Ads();
    $nAds = $ads->getTotal();
    
    $users = new User();
    $nUsers = $users->getTotal();

    $p = 1;
    $qtd = 3;

    if(isset($_GET['p']) && !empty($_GET['p'])) {
        $p = addslashes($_GET['p']);
    };

    $total_pages = ceil($nAds / $qtd);

    $list = $ads->getList($p, $qtd);                                
?>
    <main>
        <div class="jumbotron">
            <div class="container">
                <h2>Nós temos hoje <?php echo $nAds;?> anúncios.</h2>
                <p>E mais de <?php echo $nUsers;?> usuários cadastrados.</p>
            </div>
        </div>
        <div class="container content">
            <div class="row">
                <div class="col-12 col-md-3">
                    <h5>Pesquisa Avançada</h5>
                </div>
                <div class="col-12 col-md-9">
                    <h5>Últimos Anúncios</h5>
                    <div class="list-group">
                        <div class="table-responsive">
                            <ul class="list-group list-group-flush striped">
                                <?php foreach($list as $ad): ?>
                                <a href="./produto?id=<?php echo $ad['id'];?>" class="index-table-list list-group-item list-group-item-action d-flex">
                                    <div class="col-3 col-md-1 img d-flex justify-content-center">
                                        <img src="./assets/img/ads/<?php echo ($ad['img']) ? $ad['img'] : 'default.png';?>" alt="<?php echo $ad['title'];?>" width="40" height="40">
                                    </div>
                                    <div class="col d-flex flex-wrap justify-content-between align-items-center p-1">
                                        <div class="details d-flex flex-column mb-1 ">
                                            <span><?php echo $ad['title'];?></span>
                                            <small><?php echo $ad['category'];?></small>
                                        </div>
                                        <div class="price">
                                            <span class="text-center">R$ <?php echo number_format($ad['value'], 2, ",", ".");?></span>
                                        </div>
                                    </div>
                                </a>
                                <?php endforeach;?>
                            </ul>
                            <nav class="my-2" aria-label="Navegação de Anúncios">
                                <ul class="pagination justify-content-center">
                                    <?php for($i=1; $i <= $total_pages; $i++):?>
                                        <li class="page-item <?php echo ($i == $p) ? 'active' : '';?>">
                                            <a class="page-link" href="./?p=<?php echo $i;?>"><?php echo $i;?></a>
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
<?php require './pages/footer.php'; ?>
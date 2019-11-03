<?php 
    require './pages/header.php';
    require './class/ads.class.php';
    require './class/user.class.php';

    $ads = new Ads();
    $nAds = $ads->getTotal();

    $users = new User();
    $nUsers = $users->getTotal();
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
                </div>
            </div>
        </div>
    </main>
<?php require './pages/footer.php'; ?>
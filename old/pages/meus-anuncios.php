<?php require './pages/header.php'; ?>
<?php 
    if(!isset($_SESSION['cLogin']) || empty($_SESSION['cLogin'])) { 
        header('Location: ./login'); 
        exit;
    };
?>

    <main role="main" class="container mt-2 flex-shrink-0 mb-5">
        <h3 class="text-center">Meus Anúncios</h3>
        <div class="d-flex">
            <a href="./add-anuncios" class="btn btn-primary ml-auto">Adicionar Novo</a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-sm mt-3">
                <thead>
                    <tr class="text-center">    
                        <td scope="col">Foto</td>
                        <td scope="col">Titulo</td>
                        <td scope="col">Condição</td>
                        <td scope="col">Valor</td>
                        <td scope="col">Categoria</td>
                        <td scope="col">Ações</td>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        require './class/ads.class.php';
                        $a = new Ads();
                        $ads = $a->getUserList();
                        foreach($ads as $ad):
                    ?>
                        <tr>
                            <td class="text-center">
                                <img src="./assets/img/ads/<?php echo ($ad['img']) ? $ad['img'] : 'default.png';?>" alt="<?php echo $ad['title'];?>" width="40">
                            </td>
                            <td><?php echo $ad['title'];?></td>
                            <td class="text-center"><?php echo ($ad['state'] === 'N') ? 'Novo' : 'Usado';?></td>
                            <td class="text-right">R$ <?php echo number_format($ad['value'], 2, ",", ".");?></td>
                            <td class="text-center"><?php echo $ad['category'];?></td>
                            <td class="text-center">
                                <a href="./editar-anuncios?id=<?php echo $ad['id'];?>" class="btn btn-warning">Editar</a>
                                <a href="./excluir-anuncios?id=<?php echo $ad['id'];?>" class="btn btn-danger">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </main>

<?php require './pages/footer.php'; ?>
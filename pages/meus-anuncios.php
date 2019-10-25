<?php require './pages/header.php'; ?>
<?php 
    if(!isset($_SESSION['cLogin']) || empty($_SESSION['cLogin'])) { 
        header('Location: ./login'); 
        exit;
    };
?>

    <main class="container mt-5">
        <h3 class="text-center">Meus Anúncios</h3>
        <div class="d-flex">
            <a href="./add-anuncios" class="btn btn-primary ml-auto">Adicionar Novo</a>
        </div>
        <table class="table table-bordered table-hover mt-3">
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
                    $ads = $a->getList($_SESSION['cLogin']);

                    foreach($ads as $ad):
                ?>
                    <tr>
                        <td class="text-center"><img src="./assets/images/ads/<?php echo $ad['url'];?>" alt="<?php echo $ad['title'];?>"></td>
                        <td><?php echo $ad['title'];?></td>
                        <td class="text-center"><?php echo ($ad['state'] === 'N') ? 'Novo' : 'Usado';?></td>
                        <td class="text-right">R$ <?php echo number_format($ad['value'], 2);?></td>
                        <td class="text-center"><?php echo $ad['category'];?></td>
                        <td class="text-center">
                            <a href="#" class="btn btn-warning">Editar</a>
                            <a href="#" class="btn btn-danger">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </main>
    
<?php require './pages/footer.php'; ?>
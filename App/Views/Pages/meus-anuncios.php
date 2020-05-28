<main>
<div class="container">
    <h3 class="text-center">Meus Anúncios</h3>
    <div class="d-flex">
        <a href="./adicionar-anuncio" class="btn btn-primary ml-auto">Adicionar Novo</a>
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
                <?php foreach($ads as $ad):?>
                    <tr>
                        <td class="text-center">
                            <img 
                                src="<?=VIEWS['ASSETS']?>img/ads/<?=($ad->getImg()) ? $ad->getImg() : 'default.png';?>" 
                                onerror="this.src='<?=VIEWS['ASSETS']?>img/ads/default.png';"
                                alt="<?=$ad->getTitle()?>" 
                                width="40" 
                                height="40"
                            >
                        </td>
                        <td><?=$ad->getTitle()?></td>
                        <td class="text-center"><?=($ad->getState() === 'N') ? 'Novo' : 'Usado';?></td>
                        <td class="text-right">R$ <?=number_format($ad->getValue(), 2, ",", ".");?></td>
                        <td class="text-center"><?=$ad->getCategory();?></td>
                        <td class="text-center">
                            <a href="./editar-anuncio/<?=$ad->getId();?>" class="btn btn-warning">Editar</a>
                            <button 
                                type="button" 
                                class="btn btn-danger" 
                                data-href="./excluir-anuncio/<?=$ad->getId();?>">
                                    Excluir
                            </button>
                        </td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>
</main>
<script>
    let btns = document.querySelectorAll('button');
    Array.prototype.forEach.call(btns, btn => {
        btn.addEventListener('click', (e) => {
            if(confirm("Tem certeza que deseja excluir este anúncio?")) {
                let link = ((e.target).getAttribute('data-href'));
                window.location.href = link;
            };
        });
    });
</script>
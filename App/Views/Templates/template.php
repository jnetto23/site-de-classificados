<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- SEO -->
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    <meta name='viewport' content='width=device-width, initial-scale=1' />
    <meta http-equiv='X-UA-Compatible' content='ie=edge' />
    <base href='https://fyyb.com.br/preview/classificados-php/' />
    <title>Classificados PHP</title>
    <meta name='description' content='Sistema simples de classificados construido com PHP, é possivel se cadastrar e criar seus prórpios anúncios.'/>
    <meta name='keywords' content='fyyb, jnetto23, Classificados PHP, PHP, MySql, fyyb/express, portfolio, case study, estudo'/>
    <meta name='robots' content='index,follow' />
    <meta name='rating' content='General' />
    <meta name='copyright'content='Fyyb'>
    <link rel='canonical' href='https://fyyb.com.br/preview/classificados-php/' />
    <!-- Localização -->
    <meta name='geo.placename' content='São Paulo-SP'>
    <meta name='geo.region' content='SP-BR'>
    <!-- Meta Tags Facebook (https://ogp.me/) -->
    <meta property='og:url' content='https://fyyb.com.br/preview/classificados-php/'>
    <meta property='og:site_name' content='Classificados PHP'>
    <meta property='og:title' content='Classificados PHP'>
    <meta property='og:description' content='Sistema simples de classificados construido com PHP, é possivel se cadastrar e criar seus prórpios anúncios.'>
    <meta property='og:type' content='website'>
    <meta property='og:image' content='https://fyyb.com.br/preview/classificados-php/screenshots/ads_site-home.png'>
    <meta property='og:region' content='Brasil'>
    <meta property='fb:admins' content='605931989767491'>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="<?=VIEWS['ASSETS']?>css/style.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="./">Classificados</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Alterna navegação">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <?php if(isset($_SESSION['User']) && !empty($_SESSION['User'])):?>
                            <li class="nav-item">
                                <a class="nav-link" href="./meus-anuncios">Meus Anúncios</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./logout">Sair</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="./cadastre-se">Cadastre-se</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./login">Login</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    
    <?php $this->loadView($viewName, $viewData); ?>
    

    <footer class="bg-dark">
        <section class="container text-center text-light py-3 copyright">
            &copy; Copyright<script>document.write(' ' + new Date().getFullYear() + ' ');</script> &#8212; <a href="http://fyyb.com.br" target="_blank" rel=”noopener noreferrer”>Fyyb</a> <span style="color:red">&hearts;</span>
        </section>
    </footer>

    <!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="<?=VIEWS['ASSETS']?>js/script.js"></script>
</body>
</html>
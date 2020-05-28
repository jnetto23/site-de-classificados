<main class="has-form">
<div class="container">
    <form id="form-signin" method='POST'>
        <span class="text-center text-uppercase h5">Login</span>
        <hr class="divider">
        <?php if (isset($_SESSION['error']) && !empty($_SESSION['error'])): ?> 
            <div class="alert alert-danger text-center">
                <?php 
                    $error = $_SESSION['error']; 
                    unset($_SESSION['error']);
                    echo $error;
                ?>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label class="mb-1" for="email">Email:</label>
            <input class="form-control" type="email" name="email" placeholder="Informe seu Email"  autofocus>
        </div>
        <div class="form-group">
            <label class="mb-1" for="pwd">Senha:</label>
            <input class="form-control helper" type="password" name="pwd" placeholder="Informe sua senha" minlength="6" >
            <small class="d-none form-text text-muted">sua senha deve possuir no mínimo 6 caracteres.</small>
        </div>
        <input type="submit" class="btn btn-primary mt-2 mb-3" value="Entrar">
        <span class="text-center">Ainda não tem cadastro? Então <a href="./cadastre-se">Cadastre-se</a></span>
    </form>
</div>
</main>
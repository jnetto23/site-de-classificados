<main class="has-form"> 
<div class="container">
    <form id="form-signup" method='POST'>
        <span class="text-center text-uppercase h5">Cadastre-se</span>
        <hr class="divider">
        <?php if(isset($_SESSION['msg'])): ?>   
            <?php 
                $msg = $_SESSION['msg'];
                unset($_SESSION['msg']);
            ?>     
            <div class="alert alert-<?php echo $msg['class'] ?> text-center">
                <?php echo $msg['msg'];?>
            </div>
        <?php endif; ?>        
        <div class="form-group">
            <label class="mb-1" for="name">Nome:</label>
            <input class="form-control" type="text" name="name" placeholder="Informe seu Nome" required autofocus>
        </div>
        <div class="form-group">
            <label class="mb-1" for="email">Email:</label>
            <input class="form-control" type="email" name="email" placeholder="Informe seu Email" required>
        </div>
        <div class="form-group">
            <label class="mb-1" for="pwd">Senha:</label>
            <input class="form-control helper" type="password" name="pwd" placeholder="Informe sua senha" minlength="6" required>
            <small class="d-none form-text text-muted">sua senha deve possuir no mínimo 6 caracteres.</small>
        </div>
        <div class="form-group">
            <label class="mb-1" for="pwd2">Confirmação de Senha:</label>
            <input class="form-control helper" type="password" name="pwd2" placeholder="Confirme sua senha" minlength="6" required>
            <small class="d-none form-text text-muted">informe a mesma senha digitada anteriormente.</small>
        </div>
        <input type="submit" class="btn btn-primary mt-2 mb-3" value="Cadastrar">
        <span class="text-center">Já tem cadastro? Faça seu <a href="./login">Login</a></span>
    </form>
</div>
</main>
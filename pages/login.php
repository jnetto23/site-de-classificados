<?php require './pages/header.php'; ?>
    <main role="main" class="container flex-shrink-0 mb-5">
        <form id="form-signin" method='POST'>
            <span class="text-center text-uppercase h5">Login</span>
            <hr class="divider">
            <?php 
                require './class/user.class.php';
                $u = new User();

                if(isset($_POST['email']) && !empty($_POST['email'])) {
                    $email = addslashes(strtolower(trim($_POST['email'])));
                    $pwd   = addslashes($_POST['pwd']);

                    if(!empty($email) && !empty($pwd)) {
                        if(!$u->signin($email, $pwd)) { 
                            ?>
                                <div class="alert alert-danger text-center">
                                    Email e/ou senha inválidos.
                                </div>
                            <?php
                        } else {
                            header('Location: ./');
                        }; 
                    } else {
                        ?>
                            <div class="alert alert-danger text-center">
                                Preencha todos os campos!
                            </div>
                        <?php

                    };
                };
            ?>

            <div class="form-group">
                <label class="mb-1" for="email">Email:</label>
                <input class="form-control" type="email" name="email" placeholder="Informe seu Email" required autofocus>
            </div>
            <div class="form-group">
                <label class="mb-1" for="pwd">Senha:</label>
                <input class="form-control helper" type="password" name="pwd" placeholder="Informe sua senha" minlength="6" required>
                <small class="d-none form-text text-muted">sua senha deve possuir no mínimo 6 caracteres.</small>
            </div>
            <input type="submit" class="btn btn-primary mt-2 mb-3" value="Entrar">
            <span class="text-center">Ainda não tem cadastro? Então <a href="./cadastre-se">Cadastre-se</a></span>
        </form>       
    </main>
<?php require './pages/footer.php'; ?>
<?php require './pages/header.php'; ?>
    <main class="container">
        <form id="form-signup" method='POST'>
            <span class="text-center text-uppercase h5">Cadastre-se</span>
            <hr class="divider">
            <?php 
                require './class/user.class.php';
                $u = new User();

                if(isset($_POST['name']) && !empty($_POST['name'])) {
                    $name  = addslashes(ucwords(strtolower(trim($_POST['name']))));
                    $email = addslashes(strtolower(trim($_POST['email'])));
                    $pwd   = addslashes($_POST['pwd']);

                    if(!empty($name) && !empty($email) && !empty($pwd)) {
                        if(!$u->signup($name, $email, $pwd)) { 
                            ?>
                                <div class="alert alert-warning text-center">
                                    Email já Cadastrado.
                                    <a class="alert-link" href="./login">Faça o login agora.</a>
                                </div>
                            <?php
                        } else {
                            ?>
                                <div class="alert alert-success text-center">
                                    <strong>Parabéns!</strong> Usuário cadastrado com sucesso.
                                    <a class="alert-link" href="./login">Faça o login agora.</a>
                                </div>
                            <?php
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
    </main>
<?php require './pages/footer.php'; ?>
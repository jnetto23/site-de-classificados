<?php require './pages/header.php'; ?>
    <main class="container">
        <form id="form-signup" method='POST'>
            <span class="text-center text-uppercase h5">Cadastre-se</span>

            <?php 
                require './class/user.class.php';
                $u = new User();

                if(isset($_POST['name']) && !empty($_POST['name'])) {
                    $name  = addslashes(ucwords(strtolower(trim($_POST['name']))));
                    $email = addslashes(strtolower(trim($_POST['email'])));
                    $pwd   = addslashes($_POST['pwd']);

                    if(!empty($name) && !empty($email) && !empty($pwd)) {
                        $u->signup($name, $email, $pwd);
                    } else {
                        ?>
                        
                            <span class="alert alert-danger text-center">Preencha todos os campos.</span>

                        <?php
                    };
                };
            ?>



            <div class="form-group">
                <label class="mb-1" for="name">Nome:</label>
                <input class="form-control" type="text" name="name" placeholder="Informe seu Nome" required autofocus value="João MARQUES da Silva Netto">
            </div>
            <div class="form-group">
                <label class="mb-1" for="email">Email:</label>
                <input class="form-control" type="email" name="email" placeholder="Informe seu Email" required value="jnetto@fyyb.com.br">
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
            <input type="submit" class="btn btn-success mt-2 mb-3" value="Cadastrar">
        </form>
    </main>
<?php require './pages/footer.php'; ?>
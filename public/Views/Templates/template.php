<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo BASE_URL;?>Assets/css/style.css">
    <title>Template 1</title>
</head>
<body>
    <header>
        <h2>Header do Template 1</h2>
    </header>
    <main>
        <?php $this->loadView($viewName, $viewData); ?>
    </main>
    <footer>
        <h2>Footer do Template 1</h2>
    </footer>
    <script src="<?php echo BASE_URL;?>Assets/js/script.js"></script>
</body>
</html>
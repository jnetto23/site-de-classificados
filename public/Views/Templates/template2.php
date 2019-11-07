<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Template 2</title>
</head>
<body>
    <header>
        <h2>Header do Template 2</h2>
    </header>
    <hr/>
    <main>
        <?php $this->loadView($viewName, $viewData); ?>
    </main>
    <hr/>
    <footer>
        <h2>Footer do Template 2</h2>
    </footer>
</body>
</html>
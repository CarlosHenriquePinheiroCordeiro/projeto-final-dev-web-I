<?php
    require_once('autoload.php');
    session_start();
    if (!isset($_POST['user'])) {
        header('location:index.php');
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Home</title>
    </head>
    <body>
        <h1>LOGADO COM SUCESSO</h1>
        <?= Botao::getBotaoLogoff() ?>
    </body>
</html>
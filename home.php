<?php
    require_once('autoload.php');
    session_start();
    if (!isset($_SESSION['user'])) {
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
        <h1>Bem vindo <?= $_SESSION['tipo']?></h1>
        <?= TelaUtils::getBotaoLogoff() ?>
    </body>
</html>
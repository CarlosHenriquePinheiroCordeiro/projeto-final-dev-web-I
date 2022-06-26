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
        <?= TelaUtils::headPadraoPagina()?>
        <title>Home</title>
    </head>
    <body>
        <?= TelaUtils::topoPagina('Bem vindo '.$_SESSION['tipo'])?>
    </body>
</html>
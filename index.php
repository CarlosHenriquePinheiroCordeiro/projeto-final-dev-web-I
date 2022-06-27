<!DOCTYPE html>
<?php
    require_once('autoload.php');
    session_start();
    if (isset($_SESSION['user'])) {
        if (!$_SESSION['aceitaTermo']) {
            session_destroy();
        } else {
            header('location:home.php');
        }
    }
?>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
    </head>
    <body>
        <h1>Login</h1>
        <form action="login.php" method="post">
            <label for="user">Login</label>
            <input type="text" name="user">
            <br>
            <label for="pass">Senha</label>
            <input type="text" name="pass">
            <br>
            <button type="submit" name="acao" value="login">Entrar</button>
        </form>
    </body>
</html>
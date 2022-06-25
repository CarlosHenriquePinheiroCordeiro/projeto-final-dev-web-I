<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
    </head>
    <body>
        <h1>Login</h1>
        <form action="acao/acaoLogin.php" method="post">
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
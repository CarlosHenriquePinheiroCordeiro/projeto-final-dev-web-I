<!DOCTYPE html>
<?php
    require_once('autoload.php');
    session_start();
    if (!isset($_SESSION['user'])) {
        header('location:index.php');
    }
?>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Termos de uso de dados</title>
    </head>
    <body>
        <h1>Termos de uso de dados do usuário</h1>
        <p>Prezado usuário, informamos que temos políticas relativas ao uso dos dados do seu cadastro, todas dentro do escopo da Lei Geral de Proteção de Dados (LGPD).
        Antes que você possa acessar o nosso site, é de suma importância que você esteja ciente destas, e de acordo com elas.</p>
        <p>Você aceita os nossos termos de uso?</p>
        <form action="acao/acao.php" method="post">
            <input type="hidden" name="classe" value="AceitaLgpd">
            <input type="hidden" name="classeAcao" value="Usuario">
            <input type="hidden" name="acao" value="ativacao">
            <input type="hidden" name="codigo" value=<?= $_SESSION['codigoUser']?>>
            <input type="hidden" name="tela" value="home.php">
            <button type="submit">Aceito os termos</button>
        </form>
        <form action="index.php" method="post">
            <button type="submit">Não aceito</button>
        </form>
    </body>
</html>
<!DOCTYPE html>
<?php
     require_once('autoload.php');
     require_once('acao.php');
     session_start();
     if (!isset($_SESSION['user'])) {
         header('location:index.php');
     }
?>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Manutenção de Matéria</title>
    </head>
    <body>
        <form action="acao.php" method="post">
            <label for="codigo">Código</label>
            <input type="number" name="codigo" disabled readonly>
            <br>
            <label for="nome">Nome</label>
            <input type="text" name="nome">
            <br>
            <label for="descricao">Descrição</label>
            <input type="text" name="descricao">
            <br>
            <?php
                TelaUtils::telaRedirecionar('materia');
                TelaUtils::classeAcaoForm('materia');
                TelaUtils::submitInclusao();
            ?>
        </form>
    </body>
</html>
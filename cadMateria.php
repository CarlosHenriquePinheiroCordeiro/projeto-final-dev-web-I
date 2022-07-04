<!DOCTYPE html>
<?php
    require_once('acao.php');
    require_once('autoload.php');
    session_start();
    if (!isset($_SESSION['user'])) {
        header('location:index.php');
    }
    $objeto = false;
    $chave = isset($_GET['c_codigo']) ? $_GET['c_codigo'] : false;
    $acao  = isset($_GET['acao'])     ? $_GET['acao']     : 'inclusao';
    if ($chave) {
        $objeto = buscaDados('Materia');
    }
?>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Manutenção de Matéria</title>
    </head>
    <body>
        <form action="acao.php" method="post">
            <label for="c_codigo">Código</label>
            <input type="number" name="c_codigo" readonly value=<?= $objeto ? $objeto->getCodigo() : ''; ?>>
            <br>
            <label for="c_nome">Nome</label>
            <input type="text" name="c_nome" value=<?= $objeto ? $objeto->getNome() : ''; ?>>
            <br>
            <label for="c_descricao">Descrição</label>
            <input type="text" name="c_descricao" value=<?= $objeto ? $objeto->getDescricao() : ''; ?>>
            <br>
            <?php
                TelaUtils::telaRedirecionar('consultaMateria');
                TelaUtils::classeAcaoForm('materia');
                TelaUtils::classeForm('materia');
                TelaUtils::submit($acao);
            ?>
        </form>
    </body>
</html>
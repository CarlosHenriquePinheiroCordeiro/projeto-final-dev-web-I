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
    $acao  = isset($_GET['acao'])     ? $_GET['acao'] : 'inclusao';
    if ($chave) {
        $objeto = buscaDados('SalaVirtual');
    }
?>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Manutenção de Salas Virtuais</title>
    </head>
    <body>
    <form action="acao.php" method="post">
            <label for="c_codigo">Código</label>
            <input type="number" name="c_codigo" readonly value=<?= $objeto ? $objeto->getCodigo() : ''; ?>>
            <br>
            <label for="c_descricao">Descrição</label>
            <input type="text" name="c_descricao" value=<?= $objeto ? $objeto->getDescricao() : ''; ?>>
            <br>
            <label for="c_Materia.codigo">Matéria</label>
            <select name="c_Materia.codigo" value=<?= $objeto ? $objeto->getMateria()->getCodigo() : ''; ?>>
                <?= getLista('Materia')?>
            </select>
            <br>
            <?php
                TelaUtils::telaRedirecionar('consultaSalaVirtual');
                TelaUtils::classeAcaoForm('SalaVirtual');
                TelaUtils::classeForm('SalaVirtual');
                TelaUtils::submit($acao);
            ?>
        </form>
    </body>
</html>
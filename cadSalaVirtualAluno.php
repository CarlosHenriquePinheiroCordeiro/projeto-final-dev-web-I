<!DOCTYPE html>
<?php
    require_once('acao.php');
    require_once('autoload.php');
    session_start();
    if (!isset($_SESSION['user']) || !in_array($_SESSION['tipo'], [Usuario::PERFIL_ADMIN, Usuario::PERFIL_PROFESSOR])) {
        header('location:index.php');
    }
    $objeto = false;
    $chave = isset($_GET['c_codigo']) ? $_GET['c_codigo'] : false;
    $acao  = isset($_GET['acao'])     ? $_GET['acao']     : 'inclusao';
    $salaVirtual = buscaDados('SalaVirtual');
?>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Vincular aluno</title>
    </head>
    <body>
        <h2>Vincular aluno à sala virtual <?= $salaVirtual->getDescricao()?></h2>
        <form action="acao.php" method="post">
            <label for="c_SalaVirtual_codigo">Código da Sala Virtual</label>
            <input type="number" name="c_SalaVirtual_codigo" readonly value=<?= $salaVirtual->getCodigo(); ?>>
            <br>
            <?= getLista('Aluno', 'c_Aluno.codigo', 'Aluno', Lista::TIPO_SELECT)?>
            <br>
            <?php
                TelaUtils::telaRedirecionar('consultaSalaVirtualAluno', ['c_codigo='.$chave]);
                TelaUtils::classeAcaoForm('SalaVirtualAluno');
                TelaUtils::classeForm('SalaVirtualAluno');
                TelaUtils::submit($acao);
            ?>
        </form>
    </body>
</html>
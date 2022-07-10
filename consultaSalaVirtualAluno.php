<!DOCTYPE html>
<?php
    require_once('autoload.php');
    require_once('acao.php');
    session_start();
    if (!isset($_SESSION['user'])) {
        header('location:index.php');
    }
    $chaveSalaVirtual = isset($_GET['c_codigo']) ? $_GET['c_codigo'] : $_GET['codigoSalaVirtual'];
    $salaVirtual      = buscaDados('SalaVirtual');
?>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <?= TelaUtils::headPadraoPagina(); ?>
        <title>Sala Virtual - Alunos</title>
    </head>
    <body>
        <?= TelaUtils::topoPagina('Alunos da Sala Virtual '.$salaVirtual->getNome()); ?>
        <?= TelaUtils::botaoIncluir('SalaVirtualAluno', ['c_codigo='.$chaveSalaVirtual]);?>
        <?php
        $colunas = [
            ['Aluno.codigo'     , 'Código'],
            ['Aluno.Pessoa.nome', 'Nome']
        ];
        consulta('SalaVirtualAluno', $colunas, 'SalaVirtualAluno', ['codigoSalaVirtual='.$chaveSalaVirtual]);
        ?>
    </body>
</html>
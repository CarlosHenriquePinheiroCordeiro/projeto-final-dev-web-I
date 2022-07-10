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
        <title>Sala Virtual - Professores</title>
    </head>
    <body>
        <?= TelaUtils::topoPagina('Professores da Sala Virtual '.$salaVirtual->getDescricao()); ?>
        <?= TelaUtils::botaoIncluir('SalaVirtualProfessor', ['c_codigo='.$chaveSalaVirtual]);?>
        <?php
        $colunas = [
            ['Professor.codigo'     , 'Código'],
            ['Professor.Pessoa.nome', 'Nome']
        ];
        consulta('SalaVirtualProfessor', $colunas, 'SalaVirtualProfessor', ['codigoSalaVirtual='.$chaveSalaVirtual]);
        ?>
    </body>
</html>
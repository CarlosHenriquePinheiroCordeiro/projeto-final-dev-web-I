<!DOCTYPE html>
<?php
    require_once('autoload.php');
    require_once('acao.php');
    session_start();
    if (!isset($_SESSION['user'])) {
        header('location:index.php');
    }
    $chaveSalaVirtual = isset($_GET['c_codigo']) ? $_GET['c_codigo'] : (isset($_GET['c_SalaVirtual_codigo']) ? $_GET['c_SalaVirtual_codigo']: $_GET['codigoSalaVirtual']);
    $salaVirtual      = buscaDados('SalaVirtual');
?>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <?= TelaUtils::headPadraoPagina(); ?>
        <title>Registros de Aula</title>
    </head>
    <body>
        <?= TelaUtils::topoPagina('Registros de Aula - '.$salaVirtual->getNome()); ?>
        <?= TelaUtils::botaoIncluir('RegistroAula', ['c_SalaVirtual_codigo='.$chaveSalaVirtual, 'nomeSalaVirtual='.str_replace(' ', '_', $salaVirtual->getNome())]);?>
        <?php
        $colunas = [
            ['codigo'      , 'Código'],
            ['descricao'   , 'Descrição'],
            ['data'        , 'Data']
        ];
        consulta('RegistroAula', $colunas, 'RegistroAula', ['codigoSalaVirtual='.$chaveSalaVirtual, 'c_SalaVirtual_codigo='.$chaveSalaVirtual, 'nomeSalaVirtual='.str_replace(' ', '_', $salaVirtual->getNome())]);
        ?>
    </body>
</html>
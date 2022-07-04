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
        <?= TelaUtils::headPadraoPagina(); ?>
        <title>Salas Virtuais</title>
    </head>
    <body>
    <?= TelaUtils::topoPagina('Salas Virtuais'); ?>
        <?= TelaUtils::botaoIncluir('SalaVirtual');?>
        <?php
        $colunas = [
            ['codigo'      , 'Código'],
            ['descricao'   , 'Descrição'],
            ['Materia.nome', 'Matéria']
        ];
        consulta('SalaVirtual', $colunas);
        ?>
    </body>
</html>
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
        <title>Matéria</title>
        <?= TelaUtils::headPadraoPagina(); ?>
    </head>
    <body>
        <?= TelaUtils::topoPagina('Matéria'); ?>
        <?php
        $colunas = [
            ['codigo'   , 'Código'],
            ['nome'     , 'Nome'],
            ['descricao', 'Descrição']
        ];
        consulta('Materia', $colunas);
        ?>
        <?= TelaUtils::botaoIncluir('Materia');?>
    </body>
</html>
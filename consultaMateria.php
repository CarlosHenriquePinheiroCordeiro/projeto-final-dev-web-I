<!DOCTYPE html>
<?php
     require_once('autoload.php');
     require_once('acao.php');
     session_start();
     if (!isset($_SESSION['user']) || !in_array($_SESSION['tipo'], [Usuario::PERFIL_ADMIN, Usuario::PERFIL_PROFESSOR])) {
         header('location:index.php');
     }
?>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <?= TelaUtils::headPadraoPagina(); ?>
        <title>Matéria</title>
    </head>
    <body>
        <?= TelaUtils::topoPagina('Matéria'); ?>
        <?= TelaUtils::botaoIncluir('Materia');?>
        <?php
        $colunas = [
            ['codigo'   , 'Código'],
            ['nome'     , 'Nome'],
            ['descricao', 'Descrição']
        ];
        consulta('Materia', $colunas);
        ?>
    </body>
</html>
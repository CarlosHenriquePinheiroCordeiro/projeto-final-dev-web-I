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
        <title>Sala Virtual - Professores</title>
    </head>
    <body>
    <?= TelaUtils::topoPagina('Salas Virtuais - Professores'); ?>
        <?php
        $colunas = [
            ['Professor.codigo'     , 'Código'],
            ['Professor.Pessoa.nome', 'Nome']
        ];
        consulta('SalaVirtualProfessor', $colunas);
        ?>
    </body>
</html>
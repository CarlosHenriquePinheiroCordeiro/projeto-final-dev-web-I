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
        <title>Sala Virtual - Aluno</title>
    </head>
    <body>
    <?= TelaUtils::topoPagina('Sala Virtual - Alunos'); ?>
        <?php
        $colunas = [
            ['Aluno.codigo'     , 'Código'],
            ['Aluno.Pessoa.nome', 'Nome']
        ];
        consulta('SalaVirtualAluno', $colunas);
        ?>
    </body>
</html>
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
        <title>Perfis</title>
    </head>
    <body>
        <?= TelaUtils::topoPagina('Perfis'); ?>
        <?php
        $colunas = [
            ['codigo'                   , 'Código'],
            ['nome'                     , 'Nome'],
            ['dataNascimento'           , 'Data de Nascimento'],
            ['cpf'                      , 'CPF'],
            ['rg'                       , 'RG'],
            ['Usuario.TipoUsuario.nome' , 'Tipo do Usuário'],
            ['Usuario.ativo'            , 'Ativo'],
            ['Usuario.termo'            , 'Aceitou os Termos do uso de dados']
        ];
        consulta('Pessoa', 'usuario', $colunas);
        ?>
        <?= TelaUtils::botaoIncluir('Usuario');?>
    </body>
</html>
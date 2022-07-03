<!DOCTYPE html>
<?php
    require_once('acao.php');
    require_once('autoload.php');
    session_start();
    if (!isset($_SESSION['user'])) {
        header('location:index.php');
    }
    $objeto = false;
    $chave = isset($_GET['codigo']) ? $_GET['codigo'] : false;
    $acao  = isset($_GET['acao']) ? $_GET['acao'] : 'inclusao';
    if ($chave) {
        $objeto = buscaDados('Pessoa');
    }
?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Manutenção de Usuário</title>
    </head>
    <body>
        <form action="acao.php" method="post">
            <fieldset>
                <legend>Dados da Pessoa do Usuário</legend>
                <label for="c_codigo">Código</label>
                <input type="number" name="c_codigo" readonly value=<?= $objeto ? $objeto->getCodigo() : ''; ?>>
                <br>
                <label for="c_nome">Nome</label>
                <input type="text" name="c_nome" value=<?= $objeto ? $objeto->getNome() : ''; ?>>
                <br>
                <label for="c_dataNascimento">Data de Nascimento</label>
                <input type="date" name="c_dataNascimento" value=<?= $objeto ? $objeto->getDataNascimento() : ''; ?>>
                <br>
                <label for="c_cpf">CPF</label>
                <input type="number" name="c_cpf" value=<?= $objeto ? $objeto->getCpf() : ''; ?>>
                <br>
                <label for="c_rg">RG</label>
                <input type="number" name="c_rg" value=<?= $objeto ? $objeto->getRg() : ''; ?>>
            </fieldset>
            <fieldset>
                <legend>Credenciais de acesso do Usuário</legend>
                <label for="c_Usuario.codigo">Código</label>
                <input type="number" name="c_Usuario.codigo" readonly value=<?= $objeto ? $objeto->getUsuario()->getCodigo() : ''; ?>>
                <br>
                <label for="c_id">Nome</label>
                <input type="text" name="c_Usuario.id" value=<?= $objeto ? $objeto->getUsuario()->getId() : ''; ?>>
                <br>
                <label for="c_senha">Senha</label>
                <input type="text" name="c_Usuario.senha" value=<?= $objeto ? $objeto->getUsuario()->getSenha() : ''; ?>>
                <br>
                <label for="c_Usuario.TipoUsuario.codigo">Tipo do Usuário</label>
                <select name="c_Usuario.TipoUsuario.codigo">
                    <option value="2">Professor</option>
                    <option value="3">Responsável</option>
                    <option value="4">Aluno</option>
                </select>
            </fieldset>
            <br>
            <?php
                TelaUtils::telaRedirecionar('consultaUsuario');
                TelaUtils::classeAcaoForm('pessoa');
                TelaUtils::classeForm('pessoa');
                TelaUtils::submit($acao);
            ?>
        </form>
    </body>
</html>
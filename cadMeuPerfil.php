<!DOCTYPE html>
<?php
    require_once('acao.php');
    require_once('autoload.php');
    session_start();
    if (!isset($_SESSION['user'])) {
        header('location:index.php');
    }
    $objeto         = false;
    $chave          = isset($_GET['c_codigo']) ? $_GET['c_codigo'] : false;
    $acao           = isset($_GET['acao'])     ? $_GET['acao'] : 'inclusao';
    $isVisualizar   = $acao == 'visualizar';
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
            <h2>Manutenção de Usuário</h2>
            <fieldset>
                <legend>Dados da Pessoa do Usuário</legend>
                <label for="c_codigo">Código</label>
                <input type="number" name="c_codigo" readonly value=<?= $objeto ? $objeto->getCodigo() : ''; ?>>
                <br>
                <label for="c_nome">Nome</label>
                <input type="text" name="c_nome" <?= $isVisualizar ? 'readonly' : ''; ?> value="<?= $objeto ? $objeto->getNome() : ''; ?>">
                <br>
                <label for="c_dataNascimento">Data de Nascimento</label>
                <input type="date" name="c_dataNascimento" <?= $isVisualizar ? 'readonly' : ''; ?> value="<?= $objeto ? $objeto->getDataNascimento() : ''; ?>">
                <br>
                <label for="c_cpf">CPF</label>
                <input type="number" name="c_cpf" <?= $isVisualizar ? 'readonly' : ''; ?> value="<?= $objeto ? $objeto->getCpf() : ''; ?>">
                <br>
                <label for="c_rg">RG</label>
                <input type="number" name="c_rg" <?= $isVisualizar ? 'readonly' : ''; ?> value="<?= $objeto ? $objeto->getRg() : ''; ?>">
            </fieldset>
            <fieldset>
                <legend>Credenciais de acesso do Usuário</legend>
                <label for="c_Usuario.codigo">Código</label>
                <input type="number" name="c_Usuario.codigo" readonly value=<?= $objeto ? $objeto->getUsuario()->getCodigo() : ''; ?>>
                <br>
                <label for="c_id">Id</label>
                <input type="text" name="c_Usuario.id" <?= $isVisualizar ? 'readonly' : ''; ?> value="<?= $objeto ? $objeto->getUsuario()->getId() : ''; ?>">
                <br>
                <label for="c_senha">Senha (SHA12)</label>
                <input type="text" name="c_Usuario.senha" <?= $isVisualizar ? 'readonly' : ''; ?> value="<?= $objeto ? $objeto->getUsuario()->getSenha() : ''; ?>">
            </select>
            </fieldset>
            <br>
            <?php
                TelaUtils::telaRedirecionar('home');
                TelaUtils::classeAcaoForm('pessoa');
                TelaUtils::classeForm('pessoa');
                if (!$isVisualizar) {
                    TelaUtils::submit($acao);
                }
            ?>
        </form>
    </body>
</html>
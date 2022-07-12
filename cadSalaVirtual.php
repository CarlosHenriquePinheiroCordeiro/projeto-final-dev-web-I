<!DOCTYPE html>
<?php
    require_once('acao.php');
    require_once('autoload.php');
    session_start();
    $objeto             = false;
    $chave              = isset($_GET['c_codigo']) ? $_GET['c_codigo'] : false;
    $telasAssociativas  = [
        AcaoBase::ACAO_PROFESSORES   => 'consultaSalaVirtualProfessor.php?c_codigo='.$chave,
        AcaoBase::ACAO_ALUNOS        => 'consultaSalaVirtualAluno.php?c_codigo='.$chave,
        AcaoBase::ACAO_REGISTRO_AULA => 'consultaRegistroAula.php?c_codigo='.$chave
    ];
    $acao = isset($_GET['acao']) ? $_GET['acao'] : 'inclusao';
    $isVisualizar = $acao == 'visualizar';
    if (array_key_exists($acao, $telasAssociativas)) {
        header('location:'.$telasAssociativas[$acao]);
    } else if (!isset($_SESSION['user']) || (!in_array($_SESSION['tipo'], [Usuario::PERFIL_ADMIN, Usuario::PERFIL_PROFESSOR]) && !$isVisualizar)) {
        header('location:index.php');
    }
    if ($chave) {
        $objeto = buscaDados('SalaVirtual');
    }
?>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Manutenção de Salas Virtuais</title>
    </head>
    <body>
        <h2>Manutenção de Sala Virtual</h2>
        <form action="acao.php" method="post">
            <fieldset>
                <legend>Informações Gerais</legend>
                <label for="c_codigo">Código</label>
                <input type="number" name="c_codigo" readonly value="<?= $objeto ? $objeto->getCodigo() : '' ?>">
                <br>
                <label for="c_nome">Nome</label>
                <input type="text" name="c_nome" <?= $isVisualizar ? 'readonly' : ''; ?> value="<?= $objeto ? $objeto->getNome() : '' ?>">
                <br>
                <label for="c_descricao">Descrição</label>
                <input type="text" name="c_descricao" <?= $isVisualizar ? 'readonly' : ''; ?> value="<?= $objeto ? $objeto->getDescricao() : '' ?>">
                <br>
                <?= getLista('Materia', 'c_Materia.codigo', 'Matéria', Lista::TIPO_SELECT, $objeto ? $objeto->getMateria()->getCodigo() : null, $isVisualizar)?>
            </fieldset>
            <?php
            if ($acao == 'inclusao') {
            ?>
                <fieldset>
                    <legend>Professores</legend>
                    <?= getLista('Professor', 'a_SalaVirtualProfessor.Professor.codigo', 'Professores', Lista::TIPO_CHECKBOX)?>
                </fieldset>
                <fieldset>
                    <legend>Alunos</legend>
                    <?= getLista('Aluno', 'a_SalaVirtualAluno.Aluno.codigo', 'Alunos', Lista::TIPO_CHECKBOX)?>
                </fieldset>
            <?php
            }
            ?>
            <?php
                TelaUtils::telaRedirecionar('consultaSalaVirtual');
                TelaUtils::classeAcaoForm('SalaVirtual');
                TelaUtils::classeForm('SalaVirtual');
                if (!$isVisualizar) {
                    TelaUtils::submit($acao);
                }
            ?>
        </form>
    </body>
</html>
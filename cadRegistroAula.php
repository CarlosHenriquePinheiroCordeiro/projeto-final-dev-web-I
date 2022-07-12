<!DOCTYPE html>
<?php
    require_once('acao.php');
    require_once('autoload.php');
    session_start();
    if (!isset($_SESSION['user'])) {
        header('location:index.php');
    }
    $registroAula   = false;
    $chaveSalaVirtual = isset($_GET['c_SalaVirtual_codigo']) ? $_GET['c_SalaVirtual_codigo']                    : (isset($_POST['c_SalaVirtual_codigo']) ? $_POST['c_SalaVirtual_codigo']  : false);
    $nomeSalaVirtual  = isset($_GET['nomeSalaVirtual'])      ? str_replace('_', ' ', $_GET['nomeSalaVirtual'])  : false;
    $acao             = isset($_GET['acao'])                 ? $_GET['acao']                                    : 'inclusao';
    $numerosAula      = isset($_POST['numerosAula'])         ? $_POST['numerosAula']                            : 0;
    $isVisualizar     = $acao == 'visualizar';
    if (!isset($_GET['c_codigo']) && $numerosAula == 0) {
        header('location:numerosAula.php?c_SalaVirtual_codigo='.$chaveSalaVirtual);
    }
    if (isset($_GET['c_codigo'])) {
        $registroAula = buscaDados('RegistroAula');
    }
?>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Manutenção de Registro de Aula</title>
    </head>
    <body>
        <h2>Manutenção do r egistro de Aula da sala <?=$nomeSalaVirtual?></h2>
        <form action="acao.php" method="post">
            <fieldset>
                <legend>Informações Gerais</legend>
                <input type="hidden" name="c_SalaVirtualProfessor_Professor_codigo" value=<?= isset($_SESSION['codigoProfessor']) ? $_SESSION['codigoProfessor'] : 'NULL'?>>
                <input type="hidden" name="c_SalaVirtual_codigo" value=<?=$chaveSalaVirtual?>>
                <input type="hidden" name="c_qtdAulas" value=<?=$registroAula ? $registroAula->getQtdAulas() : $numerosAula?>>
                <label for="c_codigo">Código</label>
                <input type="number" name="c_codigo" readonly value="<?= $registroAula ? $registroAula->getCodigo() : '' ?>">
                <br>
                <label for="c_descricao">Descrição</label>
                <input type="text" name="c_descricao" <?= $isVisualizar ? 'readonly' : ''; ?> value="<?= $registroAula ? $registroAula->getDescricao() : '' ?>">
                <br>
                <label for="c_data">Data</label>
                <input type="date" name="c_data" <?= $isVisualizar ? 'readonly' : ''; ?> value="<?= $registroAula ? $registroAula->getData() : '' ?>">
                <br>
            </fieldset>
            <hr>
            <h3>Presenças</h3>
            <?php
                if ($registroAula && $registroAula->getPresenca() != null) {
                    $presenca = (array)json_decode($registroAula->getPresenca());
                    for ($n = 0; $n < $registroAula->getQtdAulas(); $n++) {
                        $elemento = (array)reset($presenca);
                        $valores = [];
                        if (array_key_exists(($n+1), $elemento)) {
                            $valores = $elemento[($n+1)];
                            array_shift($presenca);
                        }
                        echo '<fieldset>';
                        echo '<legend>'.($n+1).'ª Aula</legend>';
                        echo getLista('SalaVirtualAluno', 'j_'.($n+1).'_presenca', '', Lista::TIPO_CHECKBOX, $valores, $isVisualizar);
                        echo '</fieldset>';
                        echo '<br>';
                    }
                } else {
                    for ($n = 1; $n <= $numerosAula; $n++) {
                        echo '<fieldset>';
                        echo '<legend>'.$n.'ª Aula</legend>';
                        echo getLista('SalaVirtualAluno', 'j_'.$n.'_presenca', '', Lista::TIPO_CHECKBOX);
                        echo '</fieldset>';
                        echo '<br>';
                    }
                }
            ?>
            <hr>
            <?php
                TelaUtils::telaRedirecionar('consultaRegistroAula', ['codigoSalaVirtual='.$chaveSalaVirtual, 'c_codigo='.$chaveSalaVirtual]);
                TelaUtils::classeAcaoForm('RegistroAula');
                TelaUtils::classeForm('RegistroAula');
                if (!$isVisualizar) {
                    TelaUtils::submit($acao);
                }
            ?>
        </form>
    </body>
</html>
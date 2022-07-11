<!DOCTYPE html>
<?php
    require_once('autoload.php');
    session_start();
    if (!isset($_SESSION['user']) || ($_SESSION['tipo'] == Usuario::PERFIL_ALUNO)) {
        header('location:index.php');
    }
?>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Quantidade de aulas</title>
    </head>
    <body>
        <h2>Qual é a quantidade de aulas do registro?</h2>
        <form action="cadRegistroAula.php" method="post">
            <input type="hidden" name="c_SalaVirtual_codigo" value="<?= $_GET['c_SalaVirtual_codigo']?>">
            <label for="numerosAula">Quantidade de aulas</label>
            <input type="number" name="numerosAula" required>
            <button type="submit">Avançar</button>
        </form>
    </body>
</html>
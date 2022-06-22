<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Teste</title>
    </head>
    <body>
        <form action="acao/acao.php" method="post">
            <label for="nome">Nome</label>
            <input type="text" name="nome">
            <br>
            <label for="data">Data</label>
            <input type="date" name="data" id="">
            <br>
            <input type="text" name="classe" value="Aluno">
            <input type="text" name="acao" value="inclusao">
            <button type="submit">Enviar</button>
        </form>
    </body>
</html>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Teste</title>
    </head>
    <body>
        <form action="acao/acao.php" method="post">
            <label for="id">Id</label>
            <input type="number" name="id">
            <br>
            <label for="nome">Nome</label>
            <input type="text" name="nome">
            <br>
            <label for="data">Data</label>
            <input type="date" name="data" id="">
            <br>
            <input type="text" hidden name="classe" value="Aluno">
            <button type="submit" name="acao" value="inclusao">Incluir</button>
            <button type="submit" name="acao" value="alteracao">Alterar</button>
            <button type="submit" name="acao" value="exclusao">Excluir</button>
        </form>
    </body>
</html>
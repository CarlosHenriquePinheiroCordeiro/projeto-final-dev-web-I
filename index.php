<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Teste</title>
    </head>
    <body>
        <h3>Estrangeiro</h3>
        <form action="acao/acao.php" method="post">
            <label for="codigo">Id</label>
            <input type="number" name="codigo">
            <br>
            <label for="nome">Nome</label>
            <input type="text" name="nome">
            <br>
            <input type="text" hidden name="classe" value="Estrangeiro">
            <button type="submit" name="acao" value="inclusao">Incluir</button>
            <button type="submit" name="acao" value="alteracao">Alterar</button>
            <button type="submit" name="acao" value="exclusao">Excluir</button>
        </form>
        <hr>
        <h3>Aluno</h3>
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
            <label for="Estrangeiro.codigo">Estrangeiro.codigo</label>
            <input type="number" name="Estrangeiro.codigo">
            <br>
            <input type="text" hidden name="classe" value="Aluno">
            <button type="submit" name="acao" value="inclusao">Incluir</button>
            <button type="submit" name="acao" value="alteracao">Alterar</button>
            <button type="submit" name="acao" value="exclusao">Excluir</button>
        </form>
    </body>
</html>
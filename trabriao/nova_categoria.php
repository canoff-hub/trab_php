<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Criar Nova Categoria</title>
    <link rel="stylesheet" href="./estilo.css">
</head>

<body>
    <div class="container">
        <h1>Criar Nova Categoria</h1>

        <form action="processamento.php" method="POST">
            <label>Nome da Categoria:</label>
            <input type="text" name="nome_categoria" required>

            <button type="submit" name="acao" value="criar_categoria">Salvar Categoria</button>
            <a href="index.php">Voltar</a>
        </form>
    </div>
</body>
</html>

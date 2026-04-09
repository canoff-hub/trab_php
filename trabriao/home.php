<?php
require_once 'conexao.php';
$conn = getConexao();

//se for edição, busca os dados atuais
$edit_prod = null;
if (isset($_GET['editar'])) {
    $id = $_GET['editar'];
    $res = mysqli_query($conn, "SELECT * FROM produtos WHERE id_produto = $id");
    $edit_prod = mysqli_fetch_assoc($res);
}

//busca categorias para o select
$categorias = mysqli_query($conn, "SELECT * FROM categorias");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastro</title>
    <link rel="stylesheet" href="./estilo.css">

</head>
<body>
    <h1><?= $edit_prod ? "Editar Produto" : "Novo Produto" ?></h1>

    <form action="processamento.php" method="POST">
        <input type="hidden" name="id_produto" value="<?= $edit_prod['id_produto'] ?? '' ?>">
        
        <label>Nome:</label>
        <input type="text" name="nome" value="<?= $edit_prod['nome_produto'] ?? '' ?>" required><br>

        <label>Preço:</label>
        <input type="number" step="0.01" name="preco" value="<?= $edit_prod['preco'] ?? '' ?>" required><br>

        <label>Quantidade:</label>
        <input type="number" name="quantidade" value="<?= $edit_prod['quantidade'] ?? '' ?>" required><br>

        <label>Categoria:</label>
        <select name="id_categoria" required>
            <option value="">Selecione uma categoria</option>
            <?php while($cat = mysqli_fetch_assoc($categorias)): ?>
            <option value="<?= $cat['id_categoria'] ?>" 
                <?= (isset($edit_prod) && $edit_prod['id_categoria'] == $cat['id_categoria']) ? 'selected' : '' ?>>
                <?= $cat['nome_categoria'] ?>
            </option>
            <?php endwhile; ?>
        </select><br><br>

        <button type="submit" name="acao" value="<?= $edit_prod ? 'editar' : 'cadastrar' ?>">Salvar</button>
        <a href="index.php">Voltar</a>
    </form>
</body>
</html>
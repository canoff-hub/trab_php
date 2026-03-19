<?php
require_once 'conexao.php';
$conn = getConexao();

$sql = "SELECT p.*, c.nome_categoria 
        FROM produtos p 
        INNER JOIN categorias c ON p.id_categoria = c.id_categoria
        ORDER BY p.id_produto ASC";

$resultado = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Sistema Rick - Produtos</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="container">
        <h1>Controle de Estoque</h1>
        
        <div style="margin-bottom: 20px;">
            <a href="home.php" class="btn-novo">+ Cadastrar Novo Produto</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Produto</th>
                    <th>Categoria</th>
                    <th>Preço Unit.</th>
                    <th>Qtd</th>
                    <th>Subtotal</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while($linha = mysqli_fetch_assoc($resultado)): 
                    $total = $linha['preco'] * $linha['quantidade']; 
                ?>
                <tr>
                    <td><?= $linha['id_produto'] ?></td>
                    <td><?= $linha['nome_produto'] ?></td>
                    <td><strong><?= $linha['nome_categoria'] ?></strong></td>
                    <td>R$ <?= number_format($linha['preco'], 2, ',', '.') ?></td>
                    <td><?= $linha['quantidade'] ?></td>
                    <td>R$ <?= number_format($total, 2, ',', '.') ?></td>
                    <td>
                        <a href="home.php?editar=<?= $linha['id_produto'] ?>">Editar</a> | 
                        <a href="processamento.php?excluir=<?= $linha['id_produto'] ?>" 
                           style="color: red;" 
                           onclick="return confirm('Deseja realmente excluir?')">Excluir</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
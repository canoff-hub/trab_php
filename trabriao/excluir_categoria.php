<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Excluir Categoria</title>
    <link rel="stylesheet" href="./estilo.css">
</head>

<body>
    <div class="container">
        <h1>Excluir Categoria</h1>

        <?php
        require_once 'conexao.php';
        $conn = getConexao();

        // Busca todas as categorias
        $categorias = mysqli_query($conn, "SELECT * FROM categorias ORDER BY nome_categoria");

        $categoria_selecionada = null;
        $tem_produtos = false;
        $mostrar_confirmacao = false;

        if (isset($_POST['verificar_categoria'])) {
            $id_categoria = $_POST['id_categoria'];
            $categoria_selecionada = $id_categoria;

            // Verifica se há produtos associados
            $check = mysqli_query($conn, "SELECT COUNT(*) as total FROM produtos WHERE id_categoria = $id_categoria");
            $result = mysqli_fetch_assoc($check);
            $tem_produtos = $result['total'] > 0;
            $mostrar_confirmacao = $tem_produtos;
        }

        if (isset($_POST['excluir_categoria'])) {
            $id_categoria = $_POST['id_categoria'];
            $senha = $_POST['senha'];
            $confirmar_exclusao_forcada = isset($_POST['confirmar_exclusao_forcada']);

            if ($senha === SENHA_EXCLUSAO_CATEGORIA) {
                // Verifica se há produtos associados
                $check = mysqli_query($conn, "SELECT COUNT(*) as total FROM produtos WHERE id_categoria = $id_categoria");
                $result = mysqli_fetch_assoc($check);

                if ($result['total'] > 0 && !$confirmar_exclusao_forcada) {
                    echo "<p style='color: var(--btn-danger); font-weight: bold;'>Erro: Marque a opção de confirmação para excluir categoria com produtos associados.</p>";
                } else {
                    // Se há produtos e foi confirmado, ou se não há produtos
                    if ($result['total'] > 0) {
                        // Exclui produtos primeiro
                        mysqli_query($conn, "DELETE FROM produtos WHERE id_categoria = $id_categoria");
                    }
                    // Exclui a categoria
                    mysqli_query($conn, "DELETE FROM categorias WHERE id_categoria = $id_categoria");
                    echo "<p style='color: var(--btn-novo-color); font-weight: bold;'>Categoria excluída com sucesso!</p>";
                    // Recarrega as categorias após exclusão
                    $categorias = mysqli_query($conn, "SELECT * FROM categorias ORDER BY nome_categoria");
                    $categoria_selecionada = null;
                    $mostrar_confirmacao = false;
                }
            } else {
                echo "<p style='color: var(--btn-danger); font-weight: bold;'>Erro: Senha incorreta!</p>";
            }
        }
        ?>

        <form action="" method="POST">
            <label>Selecione a categoria a excluir:</label>
            <select name="id_categoria" required onchange="this.form.submit()">
                <option value="">-- Selecione uma categoria --</option>
                <?php
                mysqli_data_seek($categorias, 0); // Reset pointer
                while($cat = mysqli_fetch_assoc($categorias)):
                ?>
                    <option value="<?= $cat['id_categoria'] ?>" <?= ($categoria_selecionada == $cat['id_categoria']) ? 'selected' : '' ?>>
                        <?= $cat['nome_categoria'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <input type="hidden" name="verificar_categoria" value="1">

            <?php if ($mostrar_confirmacao): ?>
                <div style="background-color: rgba(239, 68, 68, 0.1); border: 1px solid var(--btn-danger); padding: 15px; border-radius: 8px; margin: 15px 0;">
                    <p style="color: var(--btn-danger); font-weight: bold; margin: 0 0 10px 0;">
                        ⚠️ Atenção: Esta categoria possui produtos associados!
                    </p>
                    <p style="margin: 0 0 15px 0; color: var(--text-color);">
                        Excluir esta categoria também removerá todos os produtos relacionados. Esta ação não pode ser desfeita.
                    </p>
                    <label style="display: flex; align-items: center; gap: 8px; font-weight: normal;">
                        <input type="checkbox" name="confirmar_exclusao_forcada" value="1" style="width: auto;">
                        <span>Sim, tenho certeza e quero excluir a categoria e todos os produtos associados</span>
                    </label>
                </div>
            <?php endif; ?>

            <label>Senha de confirmação:</label>
            <input type="password" name="senha" required>

            <button type="submit" name="excluir_categoria" class="btn-danger">Excluir Categoria</button>
            <a href="index.php">Voltar</a>
        </form>
    </div>
</body>
</html>
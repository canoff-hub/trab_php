<?php
require_once 'conexao.php';

$conn = getConexao();
//exclui
if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];
    mysqli_query($conn, "DELETE FROM produtos WHERE id_produto = $id");
    header("Location: index.php");
}
//cadastrar
if (isset($_POST['acao'])) {
    if ($_POST['acao'] == 'criar_categoria') {
        $nome_categoria = mysqli_real_escape_string($conn, $_POST['nome_categoria']);
        $sql = "INSERT INTO categorias (nome_categoria) VALUES ('$nome_categoria')";
        mysqli_query($conn, $sql);
        header("Location: index.php");
        exit;
    }

    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $qtd = $_POST['quantidade'];
    $id_cat = $_POST['id_categoria'];
    $id_prod = $_POST['id_produto'];

    if ($_POST['acao'] == 'cadastrar'){
        $sql = "INSERT INTO produtos (nome_produto, preco, quantidade, id_categoria) 
                VALUES ('$nome', $preco, $qtd, $id_cat)";
    } else {
        $sql = "UPDATE produtos SET 
                nome_produto='$nome', preco=$preco, quantidade=$qtd, id_categoria=$id_cat 
                WHERE id_produto=$id_prod";
    }

    mysqli_query($conn, $sql);
    header("Location: index.php");
}
<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'bd-rick');

//senha p/ excluir categorias
define('SENHA_EXCLUSAO_CATEGORIA', 'admin123');

function getConexao() {
    $conexao = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if (!$conexao) {
        die("Falha na conexão: " . mysqli_connect_error());
    }

    return $conexao;
}
 
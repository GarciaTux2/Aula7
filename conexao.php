<?php
 
$servidor = "localhost";
$porta = "3306";
$banco = "lanchonete";
$usuario = "root";
$senha = "12345678";
 
try {
    $conexao = new PDO(
        "mysql:host=$servidor;port=$porta;
        dbname=$banco;charset=utf8mb4",
        $usuario,
        $senha
    );
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexao->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    //echo "Conexão realizada com suscesso!";
} catch (PDOException $e) {
    echo "Erro na conexão: " . $erro->getMessage();
    exit;
}
 
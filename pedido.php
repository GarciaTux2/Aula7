<?php
require 'conexao.php';
 
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('Location: index.php');
    exit;
}
 
// Lê os campos do formulário e  aceita somente os numeros
 
$codigo = filter_input(INPUT_POST, 'id_lanche',
FILTER_VALIDATE_INT);
$quantidade = filter_input(INPUT_POST, 'quantidade',
FILTER_VALIDATE_INT);
 
// Indentifica um valor invalido
if (!$codigo || $codigo < 1) {
    exit('Código do produto inválido. <a href="index.php">Voltar</a>');
}
 
// Indentifica um valor invalido
if (!$quantidade || $quantidade < 1 || $quantidade > 100) {
    exit('Quantidade inválida. <a href="index.php">Voltar</a>');
}
 
// Busca o nome e preço de um produto ativo no banco
$sql = 'SELECT nome, preco_cliente FROM produto
where id_lanche = ? and ativo = 1';
$consulta = $conexao->prepare($sql);
$consulta->execute([$codigo]);
 
$produto = $consulta->fetch(PDO::FETCH_ASSOC);
 
// Verifica se a busca encontrou ativo, caso contrário interrompe busca
 
if (!$produto){
    exit('Produto não encontrado ou inativo.
    <a href="index.php">Voltar</a>');
}
 
// o preço pode ser zero, mão não vazio null ou negativo
if ($produto['preco_cliente'] === null ||
    $produto['preco_cliente'] < 0) {
        exit('Produto sem preço definido.
        <a href="index.php">Voltar</a>');
    }
 
//calculo do preço unitário do lanche * quantidade
$total = $produto['preco_cliente'] * $quantidade;
?>
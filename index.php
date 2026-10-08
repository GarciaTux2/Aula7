<?php
 
// Solicita a conexão com o banco de dados
require 'conexao.php';
 
$consulta = $conexao->query(
    'SELECT id_lanche, nome, preco_cliente, imagem_url
    from produto where ativo = 1
    and preco_cliente IS NOT NULL
    and preco_cliente >= 0
    order by nome'
);
$produtos = $consulta->fetchALL();
?>
 
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lanchonete do 1IDS SRPQ</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
<main class="container">
        <p class="chamada"> Cardápio feito na aula de PBE1 </p>
        <h1>Lanchonete do 1 IDS SRPQ</h1>
        <h2>Cardápio</h2>
 
        <div class="cardapio">
            <?php foreach ($produtos as $produto)  { ?>
            <?php
            $imagem = trim($produto['imagem_url'] ?? '');
            $imagemValida = filter_var($imagem, FILTER_VALIDATE_URL)
            && in_array(strtolower(parse_url($imagem, PHP_URL_SCHEME) ?? ''),
            ['http', 'https']);
            ?>
 
            <!-- continuação do código -->
 
            <article class="produto">
                <div class="foto">
                    <spam>Imagem indisponível</span>
                    <?php if ($imagemValida) { ?>
                    <img src="<?= htmlspecialchars($imagem, ENT_QUOTES, 'UTF-8') ?>
                    " alt="<? htmlspecialchars($produto['nome'], ENT_QUOTES, 'UTF-8') ?> ">
                    loading="lazy" oneerror="this.remove()">
                    <?php } ?>
</div>
        <div class="detalhes">
            <span class="codigo">Código <?= $produto['id_lanche'] ?></span>
            <h3><?= htmlspecialchars($produto['nome'], ENT_QUOTES, 'UTF-8') ?></h3>
            <P class="preco">R$ <?= number_format($produto['preco_cliente'], 2, ',', '.') ?> </p>
</div>
</article>
<?php } ?>
</div>
 
<h2>Calcular Pedido</h2>
 
<form action="pedido.php" method="post">
    <label for="id_lanche">Código do produto:</label>
    <input type="number" name="id_lanche" id="id_lanche" required>
    <label for="quatidade">Quantidade:</label>
    <input type="number" name="quantidade" id="qauntidade" min="1" max="100" required>
    <button type="submit">Calcular</button>
</form>
<p> Escolha um produto por pedido. Limite: 100 unidades. </p>
 
</main>
   
</body>
</html
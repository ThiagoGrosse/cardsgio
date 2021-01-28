<?php
include 'database/login.php';

$conn = dbON();

$query = 'SELECT pc.sku, pc.nome, pc.conjunto, pc.nome_img, pc.dir_img, ppe.estoque, ppe.preco FROM produto_cadastro pc 
    INNER JOIN produto_preco_estoque ppe ON pc.sku = ppe.sku
    WHERE ppe.estoque > 0
    AND pc.condicao = "rara"
    ORDER BY last_update DESC';

$dados = $conn->query($query);
$result = mysqli_fetch_all($dados, MYSQLI_ASSOC);

$conn->close();

echo json_encode($result);
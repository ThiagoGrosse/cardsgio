<?php
session_start();

require_once '../helper/Url.php';

$sku = $_POST['sku'];
$nome = $_POST['nome'];
$preco = $_POST['preco'];
$img = $_POST['img'];
$qt = $_POST['qt'];

$vl = str_replace(",", ".", $preco);
$total = number_format($qt * $preco, 2);

$itens = [
    'sku' => $sku,
    'nome' => $nome,
    'valor' => $preco,
    'img' => $img,
    'quantidade' => $qt,
    'total' => str_replace(".", ",", $total)
];

if (empty($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [$itens];
} else {
    array_push($_SESSION['carrinho'], $itens);
}

echo json_encode($_SESSION['carrinho']);

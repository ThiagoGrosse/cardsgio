<?php
session_start();
$itens = $_SESSION['carrinho'];
$sku = $_POST['sku'];
$indice = "";

foreach ($itens as $key => $value) {
    if ($value['sku'] == $sku) {
        $indice = $key;
    }
}

unset($itens[$indice]);

$_SESSION['carrinho'] = $itens;

echo json_encode($itens);

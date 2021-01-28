<?php

require_once '../database/login.php';
require_once '../model/produtos.php';

$sku = $_POST['sku'];

$p = new Produtos;
$dados = $p->deleta_produto($sku);

echo json_encode($dados);
<?php

require_once '../database/login.php';
require_once '../model/pedidos.php';

$pedido = $_POST['pedidoModal'];
$novoStatus = $_POST['status'];

$p = new Pedidos;

if ($novoStatus != 'CAN') {
    
    $result = $p->atualizaPedido($pedido, $novoStatus);

    echo json_encode($result);
} else {

    $itens = $p->getItensPedido($pedido);
    $p->reduzEstoque($itens);
    
    $result = $p->atualizaPedido($pedido, $novoStatus);

    echo json_encode($result);
}

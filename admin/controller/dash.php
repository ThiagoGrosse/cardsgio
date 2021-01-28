<?php

require_once '../database/login.php';
require_once '../../app/model/pedido.php';

$data01 = date('Y-m-d', strtotime(str_replace("/", "-", $_POST['dataInicial'])));
$data02 = date('Y-m-d', strtotime(str_replace("/", "-", $_POST['dataFinal'])));

$p = new Pedidos;
$pedidos = $p->getPedidosDash($data01, $data02);
$status = $p->getPedidosStatus();

$valorPedido = [];
$datasPedidos = [];
$quantidadePedidos = [];
$statusPedidos = [];

foreach ($pedidos as $i) {
    $valorPedido[] = $i['valor'];
    
    $data = str_replace("-", "/", $i['data_pedido']);
    
    $datasPedidos[] = date('d/m/Y', strtotime($data));
}

foreach($status as $i){
    $quantidadePedidos[]=(int)$i['quantidade'];
    $statusPedidos[]=$i['status_pedido'];
}

echo json_encode(['datas' => $datasPedidos, 'valores'=>$valorPedido,'status'=>$statusPedidos,'quantidade'=>$quantidadePedidos]);

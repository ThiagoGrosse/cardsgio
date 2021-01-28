<?php

require_once '../database/login.php';
require_once '../model/pedidos.php';

$p = new Pedidos;

$idPedido = $_POST['idPedido'];

$result = $p->getItensPedido($idPedido);

echo json_encode($result);

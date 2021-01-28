<?php

session_start();

require_once '../database/login.php';
require_once 'calculaCarrinho.php';
require_once '../model/pedido.php';

$cliente = $_POST['nome'];
$email = $_POST['email'];
$contato = $_POST['contato'];

$itens = $_SESSION['carrinho'];
$valorCarrinho = calculaCarrinho();

$p = new Pedidos;
$pedido = $p->creatOrder($itens, $valorCarrinho, $cliente, $email, $contato);

session_destroy();
echo json_encode($pedido);
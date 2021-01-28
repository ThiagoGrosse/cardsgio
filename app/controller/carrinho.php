<?php

session_start();

require_once '../database/login.php';
require_once 'calculaCarrinho.php';

$sku = $_POST['sku'];
$qt = $_POST['qt'];

$itens = [];

foreach ($_SESSION['carrinho'] as $i) {

    $ver_estoque = consultaSaldo($sku);

    if ($qt <= (int)$ver_estoque['estoque']) {
        if ($i['sku'] == $sku) {
            $i['quantidade'] = $qt;
            $valor = $i['valor'];
            $v_valor = str_replace(",", ".", $valor);
            $total = number_format($qt * $v_valor, 2);

            $i['total'] = $total;

            $result = ['tipo'=>'success', 'msg'=>str_replace('.',',',$total)];
        }
    } else {
        $result = ['tipo' => 'Error', 'msg' => "Saldo indisponível"];
    }

    $itens[] = $i;
}

$_SESSION['carrinho'] = $itens;


$valorCarrinho = calculaCarrinho();


echo json_encode([$result, 'carrinho'=>$valorCarrinho]);


function consultaSaldo($sku)
{
    $conn = dbON();
    $dados = $conn->query('SELECT estoque FROM produto_preco_estoque WHERE sku =' . $sku);
    $result = mysqli_fetch_assoc($dados);
    $conn->close();

    return $result;
}

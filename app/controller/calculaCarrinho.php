<?php

function calculaCarrinho()
{
    $somaValor = [];
    foreach ($_SESSION['carrinho'] as $i) {
        $valor = $i['valor'] * $i['quantidade'];
        $somaValor[] = $valor;
    }
    $result = number_format(array_sum($somaValor), 2);

    return str_replace(".", ",", $result);
}

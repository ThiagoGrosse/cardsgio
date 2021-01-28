<?php
session_start();
session_destroy();

if ($_SESSION['carrinho']) {
    echo json_encode('Erro ao limpar carrinho');
} else {
    echo json_encode('Carrinho limpo');
}
<?php

require_once '../model/produtos.php';
require_once '../database/login.php';

if(!isset($_POST['condicao'])){
    $msg = ['Erro' => 'Condição não foi selecionada'];
    die(json_encode($msg));
}

/*
    Dados do produto
*/
$titulo = $_POST['titulo'];
$conjunto = $_POST['conjunto'];
$condicao = $_POST['condicao'];
$preco = str_replace(",",".",$_POST['preco']);
$estoque = $_POST['estoque'];

/*
    Dados da imagem
*/
$img_nome = $_FILES['img']['name'];
$img_dir = $_FILES['img']['tmp_name'];
$img_type = $_FILES['img']['type'];

/*
    Destino onde as imagens dos produtos cadastrados serão salvas
*/
$destino = '../../assets/img/produtos';

$extensao = pathinfo($img_nome, PATHINFO_EXTENSION);

$extensao = strtolower($extensao);

$p = new Produtos;
$sku = $p->gerador_sku();

/*
    Verifica se a extensão da imagem é jpg ou jpeg
*/
if (strstr('.jpg;.jpeg;', $extensao)) {

    $novoNome = $sku . '.' . $extensao;

    if (!move_uploaded_file($img_dir, $destino . '/' . $novoNome)) {
        die(json_encode($msgError = ['msg' => 'Erro ao salvar imagem']));
    }
} else {
    die(json_encode($msgError = ['msg' => 'Imagem com extensão errada']));
}

$diretorio = str_replace('../', '', $destino);

$result = $p->cadastra_produto($sku, $titulo, $condicao, $conjunto, $estoque, $preco, $diretorio, $novoNome);

echo json_encode($result);

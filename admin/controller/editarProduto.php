<?php

require_once '../database/login.php';
require_once '../model/produtos.php';

$titulo = $_POST['titulo'];
$conjunto = $_POST['conjunto'];;
$preco = str_replace("R$ ", "", str_replace(",", ".", $_POST['preco']));
$estoque = $_POST['estoque'];
$sku = $_POST['sku'];

$p = new Produtos;

if (!empty($_FILES['img']['name'])) {

    /*
        Atualiza img produto
    */
    $nomeImagem = $_FILES['img']['name'];
    $dir = $_FILES['img']['tmp_name'];
    $destino = '../../assets/img/produtos';

    $extensao = pathinfo($nomeImagem, PATHINFO_EXTENSION);

    $extensao = strtolower($extensao);

    if (strstr('.jpg;.jpeg;', $extensao)) {

        $novoNome = $sku . '.' . $extensao;

        if (!move_uploaded_file($dir, $destino . '/' . $novoNome)) {

            $alteraImagem = 'Erro ao salvar imagem';
        } else {

            $diretorio = str_replace('../', '', $destino);

            $alteraImagem = 'Imagem alterada';
        }
    } else {

        $alteraImagem = 'Imagem com extensão errada';
    }

} else {

    $alteraImagem = 'Imagem não alterada';
}

if (isset($_POST['condicao'])) {

    /*
        Atauliza condição
    */
    $condicao = $_POST['condicao'];

    $alteraCondicao = $p->edita_condicacao($sku, $condicao);
} else {

    $alteraCondicao = 'Condição não alterado';
}

/*
    Atualiza produto e estoque
*/
$alteraProduto = $p->edita_produto($sku, $titulo, $conjunto);
$alteraPrecoEstoque = $p->edita_preco_estoque($sku, $preco, $estoque);

$result = [
    'produto' => $alteraProduto,
    'preco_estoque' => $alteraPrecoEstoque,
    'condicao' => $alteraCondicao,
    'imagem' => $alteraImagem
];

echo json_encode($result);

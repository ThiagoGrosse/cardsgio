<?php

$link = $_POST['link'] ?? null;
$tipo = $_POST['tipo'] ?? null;
$ordem = $_POST['ordem'] ?? null;
$file = $_FILES;


$destino = $_SERVER['DOCUMENT_ROOT'] . '/siteNovoGio/adminNovo/public/assets/img/banners';

$extensaoPermitida = array("jpg", "jpeg", "png");

$imagems = [];
$x = 1;

foreach ($file as $i) {


    $nameImage = $i['name'] ?? null;
    $imgDir = $i['tmp_name'] ?? null;
    $imgType = $i['type'] ?? null;
    $imgSize = $i['size'] ?? null;

    if ($nameImage) {

        $extensao = pathinfo($nameImage, PATHINFO_EXTENSION);
        $extensao = strtolower($extensao);

        $confereExtensao = in_array($extensao, $extensaoPermitida);

        if (!is_null($confereExtensao)) {

            if ($imgSize <= 358400) {

                $novoNome = $tipo . '-' . $ordem . '.' . $extensao;
                $novoDiretorio = $destino . '/' . $novoNome;

                if (!move_uploaded_file($imgDir, $novoDiretorio)) {
                    die(json_encode(['msg' => 'Erro ao salvar imagem']));
                }
            } else {
                die(json_encode(['msg' => 'Imagem em tamanho incorreto']));
            }
        } else {
            die(json_encode(['msg' => 'Imagem com extensão errada']));
        }
    }
    $x++;
}

$msg = [
    'tipo' => 'sucesso',
    'msg' => [
        'link' => $link,
        'tipo' => $tipo,
        'ordem' => $ordem,
        'nomeImagem' => $novoNome
    ]
];

die(json_encode($msg));

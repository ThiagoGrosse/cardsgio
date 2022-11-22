<?php

$idItem = $_POST['idItem'];
$files = $_FILES;


$destino = $_SERVER['DOCUMENT_ROOT'] . '/siteNovoGio/adminNovo/public/assets/img/produtos';


$extensaoPermitida = array("jpg", "jpeg", "png");

$imagems = [];
$x = 1;

foreach ($files as $i) {

    $nameImage = $i['name'] ?? null;
    $imgDir = $i['tmp_name'] ?? null;
    $imgType = $i['type'] ?? null;
    $imgSize = $i['size'] ?? null;

    if ($nameImage) {

        $extensao = pathinfo($nameImage, PATHINFO_EXTENSION);
        $extensao = strtolower($extensao);

        $confereExtensao = in_array($extensao, $extensaoPermitida);

        if ($confereExtensao) {

            if ($imgSize <= 358400) {

                $novoNome = $idItem . '-' . $x . '.' . $extensao;
                $novoDiretorio = $destino . '/' . $novoNome;
                $imagems[] = $novoNome;

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

$dados = [
    "produto" => $idItem,
    'img_01' => $imagems[0] ?? null,
    'img_02' => $imagems[1] ?? null,
    'img_03' => $imagems[2] ?? null,
    'img_04' => $imagems[3] ?? null,
    'img_05' => $imagems[4] ?? null,
    'img_06' => $imagems[5] ?? null
];

die(json_encode($dados));

<?php

if (!empty($_FILES['banner']['name'])) {

    $nomeImagem = $_FILES['banner']['name'];
    $dir = $_FILES['banner']['tmp_name'];
    $destino = '../../assets/img/banners';
    $width = getimagesize($dir)[0];
    $heigth = getimagesize($dir)[1];
    $ordem = $_POST['ordem'];

    if ($width >= 1300 && $heigth >= 350) {
        $extensao = pathinfo($nomeImagem, PATHINFO_EXTENSION);

        $extensao = strtolower($extensao);

        if (strstr('.jpg;.jpeg;', $extensao)) {

            $novoNome ="banner0".$ordem . '.' . $extensao;

            if (!move_uploaded_file($dir, $destino . '/' . $novoNome)) {

                $msg = ['Erro'=>'Erro ao salvar imagem'];
            } else {

                $diretorio = str_replace('../', '', $destino);

                $msg = ['Sucesso' => 'Banner alterada'];
            }
        } else {

            $msg = ['Erro' => 'Banner com extensão errada'];
        }
    } else {
        $msg = ['Erro' => 'Banner no tamanho incorreto'];
    }

    echo json_encode($msg);
}

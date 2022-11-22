<?php

$urlAtual = $_SERVER['REQUEST_URI'];
$arrayUrl = explode("/", $urlAtual);

$totalPartesUrl = count($arrayUrl);
$paginaAtual = $arrayUrl[$totalPartesUrl - 1];

$GLOBALS['pagina-atual'] = $paginaAtual;
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Admin | Card's Gio</title>

    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    <link href='https://fonts.googleapis.com/css?family=Electrolize' rel='stylesheet'>

    <!-- Template Stylesheet -->
    <link href="assets/css/styles.css" rel="stylesheet">
    <link href="assets/css/myStyle.css" rel="stylesheet">
</head>
<?php

use core\Router;

$router = new Router();

$router->get('/', 'HomeController@index');
$router->get('/produtos', 'ProdutosController@index');
$router->get('/pedidos', 'PedidosController@index');
$router->get('/categorias', 'CategoriasController@index');
$router->get('/banners', 'BannersController@index');
$router->post('/uploadfile', 'UploadFile@index');
$router->post('/uploadbanner', 'UploadBanner@index');
$router->post('/categorias', 'CategoriasController@cadastro');

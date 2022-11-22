<?php
use core\Router;

$router = new Router();

$router->get('/', 'HomeController@index');
$router->get('/produtos', 'ProdutosController@index');
$router->get('/produto/{id}', 'ProdutosController@produtoID');
$router->get('/categoria/{id}', 'ProdutosController@categoriasID');

<?php

use App\Controller\BannersController;
use App\Controller\CarrinhoController;
use App\Controller\CategoriasController;
use App\Controller\ConsultaDados;
use App\Controller\ImagensController;
use App\Controller\InventarioController;
use App\Controller\PedidosController;
use App\Controller\PrecoController;
use App\Controller\ProdutosController;

use function Src\slimConfiguration;

$app = new \Slim\App(slimConfiguration());

$app->add(function ($request, $response, $next) {
    $response = $next($request, $response);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization, FormData, multipart/form-data')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST')
        ->withHeader('Access-Control-Allow-Credentials', false);
});




/**
 * ROTAS PARA PRODUTOS
 */

$app->post('/produto/cadastrar', ProdutosController::class . ':cadastrarProduto');
$app->post('/produto/atualizar', ProdutosController::class . ':atualizarProduto');
$app->get('/produto/deletar/{id}', ProdutosController::class . ':deletarProduto');




/**
 * ROTAS PARA PEDIDOS
 */

$app->post('/pedido/cadastrar', PedidosController::class . ':cadastrarPedido');
$app->post('/pedido/atualizar', PedidosController::class . ':atualizarPedido');
$app->post('/pedido/status', PedidosController::class . ':statusPedido');



/**
 * ROTA PARA ATUALIZAÇÃO DE ESTOQUE
 */

$app->post('/saldo/atualiza', InventarioController::class . ':atualizaSaldo');



/**
 * ROTA PARA ATUALIZAÇÃO DE PREÇO
 */

$app->post('/preco/atualiza', PrecoController::class . ':atualizaPreco');



/**
 * ROTA PARA SALVAR DADOS DOS BANNERS
 */

$app->post('/banner', BannersController::class . ':gravaBanner');



/**
 * ROTA PARA SALVAR DADOS DE IMAGEM DE PRODUTO
 */

$app->post('/imagem/produto', ImagensController::class . ':salvaImagens');



/**
 * ROTA CRUD CARRINHO
 */

$app->post('/carrinho', CarrinhoController::class . ':salvaCarrinho');



/**
 * ROTAS PARA CATEGORIAS
 */

$app->post('/categoria/criar', CategoriasController::class . ':criarCategoria');
$app->post('/categoria/atualizar', CategoriasController::class . ':atualizarCategoria');
$app->get('/categoria/deletar/{id}[/{idSub}]', CategoriasController::class . ':deletarCategoria');


/**
 * ROTAS PARA CONSULTAS
 */

$app->get('/consulta/produto/{id}', ConsultaDados::class . ':produtoIndividual');
$app->get('/consulta/produtos', ConsultaDados::class . ':todosProdutos');
$app->get('/consulta/produtos/excluidos', ConsultaDados::class . ':produtosExcluídos');
$app->get('/consulta/produtos/categoria/{categoria}', ConsultaDados::class . ':produtosCategoria');
$app->get('/consulta/produtos/status/{status}', ConsultaDados::class . ':produtosStatus');
$app->get('/consulta/produtos/destaque', ConsultaDados::class . ':produtosDestaque');

$app->get('/consulta/pedido/{id}', ConsultaDados::class . ':pedidoPorID');
$app->get('/consulta/pedidos', ConsultaDados::class . ':todosPedidos');
$app->get('/consulta/pedidos/status/{status}', ConsultaDados::class . ':pedidosPorStatus');

$app->get('/consulta/categorias', ConsultaDados::class . ':todasCategorias');
$app->get('/consulta/categorias/ativas', ConsultaDados::class . ':categoriasAtivas');

$app->get('/consulta/banner', ConsultaDados::class . ':getBanners');

$app->run();

<?php

namespace App\Controller;

use App\Model\Banner;
use App\Model\Categorias;
use App\Model\Imagens;
use App\Model\Pedidos;
use App\Model\Produtos;
use App\Model\SubCategoria;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ConsultaDados
{

    /**
     * FUNÇÃO QUE BUSCA DADOS DE PRODUTOS PELO ID
     */
    public function produtoIndividual(Request $request, Response $response, array $args): Response
    {
        $msg = [];



        /**
         * Obtem ID produto
         */

        $idProduto = $args['id'];


        /**
         * Busca dados do produto
         */
        $db = Produtos::select(
            'Produtos.id as SKU',
            'Produtos.titulo as tituloProduto',
            'Produtos.descricao as descricao',
            'Produtos.categoria as categoria',
            'precos.preco as preco',
            'inventario.saldo as saldo',
            'Produtos.destaque as destaque',
            'Produtos.destaque_2 as destaque02',
            'Produtos.status as statusProduto',
            'Produtos.qt_vendida as quantidadeVendida',
            'Produtos.created_at as dataCriado',
            'Produtos.updated_at as ultimaAlteracao',
            'imagens.img_01 as imagem01',
            'imagens.img_02 as imagem02',
            'imagens.img_03 as imagem03',
            'imagens.img_04 as imagem04',
            'imagens.img_05 as imagem05',
            'imagens.img_06 as imagem06',
        )
            ->join('inventario', 'inventario.id_produto', '=', 'Produtos.id')
            ->leftJoin('imagens', 'imagens.id_produto', '=', 'Produtos.id')
            ->join('precos', 'precos.id_produto', '=', 'Produtos.id')
            ->whereNull('deleted_at')
            ->where('Produtos.id', '=', $idProduto)
            ->first();

        if (is_null($db)) {


            $msg = [
                'tipo' => 'erro',
                'msg' => 'Produto não encontrado'
            ];

            return ResponseController::res400($response, $msg);
        }

        $img = Imagens::where('id_produto', '=', $idProduto)->first();
        $categoria = Categorias::select('id_categoria as id', 'titulo', 'status')
            ->where('id_categoria', '=', $db['categoria'])
            ->first() ?? null;

        if (is_null($categoria)) {
            $categoria = SubCategoria::select('id_sub as id', 'subcategoria as titulo', 'status')
                ->where('id_sub', '=', $db['categoria'])
                ->first();
        }


        $msg = [
            'tipo' => 'sucesso',
            'msg' => $db,
            'imagens' => $img,
            'categoria' => $categoria
        ];

        return ResponseController::res200($response, $msg);
    }


    /**
     * FUNÇÃO QUE BUSCA DADOS DE TODOS OS PRODUTOS
     */
    public function todosProdutos(Request $request, Response $response)
    {
        $msg = [];



        /**
         * Busca dados de todos os produtos
         */
        $db = Produtos::select(
            'Produtos.id as SKU',
            'Produtos.titulo as tituloProduto',
            'Produtos.descricao as descricao',
            'categorias.titulo as categoria',
            'categorias.id_categoria as idCategoria',
            'subcategoria.id_sub as idSubcategoria',
            'subcategoria.subcategoria as subcategoria',
            'precos.preco as preco',
            'inventario.saldo as saldo',
            'Produtos.destaque as destaque',
            'Produtos.destaque_2 as destaque02',
            'Produtos.status as statusProduto',
            'Produtos.qt_vendida as quantidadeVendida',
            'Produtos.created_at as dataCriado',
            'Produtos.updated_at as ultimaAlteracao',
            'imagens.img_01 as imagem01',
            'imagens.img_02 as imagem02',
            'imagens.img_03 as imagem03',
            'imagens.img_04 as imagem04',
            'imagens.img_05 as imagem05',
            'imagens.img_06 as imagem06',
        )
            ->join('inventario', 'inventario.id_produto', '=', 'Produtos.id')
            ->leftJoin('imagens', 'imagens.id_produto', '=', 'Produtos.id')
            ->join('precos', 'precos.id_produto', '=', 'Produtos.id')
            ->leftJoin('categorias', 'categorias.id_categoria', '=', 'Produtos.categoria')
            ->leftJoin('subcategoria', 'subcategoria.id_sub', '=', 'Produtos.categoria')
            ->whereNull('deleted_at')
            ->get();


        /**
         * Valida se retornou algum registro
         */
        if (is_null($db)) {


            $msg = [
                'tipo' => 'erro',
                'msg' => 'Nenhum produto encontrado'
            ];

            return ResponseController::res404($response, $msg); // Retorna msg
        } else {

            $msg = [
                'tipo' => 'sucesso',
                'totalProdutos' => count($db),
                'msg' => $db
            ];

            return ResponseController::res200($response, $msg); // Retorna resultado
        }
    }

    /**
     * FUNÇÃO QUE BUSCA PRODUTO EXCLUIDOS
     */
    public function produtosExcluídos(Request $request, Response $response)
    {
        $msg = [];



        /**
         * Busca dados de todos os produtos
         */
        $db = Produtos::whereNotNull('deleted_at')->get();



        /**
         * Valida se retornou algum registro
         */
        if (is_null($db)) {


            $msg = [
                'tipo' => 'erro',
                'msg' => 'Nenhum produto encontrado'
            ];

            return ResponseController::res404($response, $msg); // Retorna msg
        } else {

            $msg = [
                'tipo' => 'sucesso',
                'totalProdutos' => count($db),
                'msg' => $db
            ];

            return ResponseController::res200($response, $msg); // Retorna resultado
        }
    }


    /**
     * FUNÇÃO QUE BUSCA DADOS DE PRODUTOS POR CATEGORIA
     */
    public function produtosCategoria(Request $request, Response $response, array $args)
    {
        $msg = [];

        $idCategoria = $args['categoria'];


        $db = Produtos::select(
            'Produtos.id as sku',
            'Produtos.titulo as titulo',
            'precos.preco as preco',
            'imagens.img_01 as imagemPrincipal'
        )
            ->join('imagens', 'imagens.id_produto', '=', 'Produtos.id')
            ->join('precos', 'precos.id_produto', '=', 'Produtos.id')
            ->join('inventario', 'inventario.id_produto', '=', 'Produtos.id')
            ->whereNull('Produtos.deleted_at')
            ->where('inventario.saldo', '>', 0)
            ->where('Produtos.status', 1)
            ->where('Produtos.categoria', '=', $idCategoria)
            ->get();


        if (is_null($db)) {

            $msg = [
                'tipo' => 'erro',
                'msg' => 'Nenhum produto encontrado'
            ];


            return ResponseController::res400($response, $msg);
        } else {

            $msg = [
                'tipo' => 'sucesso',
                'msg' => $db
            ];

            return ResponseController::res200($response, $msg);
        }
    }


    /**
     * FUNÇÃO QUE BUSCA PRODUTOS POR DESTAQUE
     */
    public function produtosDestaque(Request $request, Response $response)
    {

        $msg = [];



        /**
         * Busca produtos listado como destaque 2
         */
        $dbDestaque = Produtos::select(
            'Produtos.id as sku',
            'Produtos.titulo as titulo',
            'precos.preco as preco',
            'imagens.img_01 as imagemPrincipal'
        )
            ->join('imagens', 'imagens.id_produto', '=', 'Produtos.id')
            ->join('precos', 'precos.id_produto', '=', 'Produtos.id')
            ->join('inventario', 'inventario.id_produto', '=', 'Produtos.id')
            ->whereNull('Produtos.deleted_at')
            ->where('inventario.saldo', '>', 0)
            ->where('Produtos.status', 1)
            ->where('Produtos.destaque', 1)
            ->get();



        /**
         * Busca produtos listado como destaque 2
         */
        $dbDestaque2 = Produtos::select(
            'Produtos.id as sku',
            'Produtos.titulo as titulo',
            'precos.preco as preco',
            'imagens.img_01 as imagemPrincipal'
        )
            ->join('imagens', 'imagens.id_produto', '=', 'Produtos.id')
            ->join('precos', 'precos.id_produto', '=', 'Produtos.id')
            ->join('inventario', 'inventario.id_produto', '=', 'Produtos.id')
            ->whereNull('Produtos.deleted_at')
            ->where('inventario.saldo', '>', 0)
            ->where('Produtos.status', 1)
            ->where('Produtos.destaque_2', 1)
            ->get();


        /**
         * Retorna resultados da busca
         */
        $msg = [
            'tipo' => 'sucesso',
            'msg' => [
                'destaque' => $dbDestaque,
                'destaque2' => $dbDestaque2
            ]
        ];

        return ResponseController::res200($response, $msg);
    }

    /**
     * FUNÇÃO QUE BUSCA PRODUTOS POR STATUS
     */
    public function produtosStatus(Request $request, Response $response, array $args)
    {
        $msg = [];



        /**
         * Obtem status
         */

        $status = $args['status'];



        /**
         * Busca produtos com base no status
         */

        $db = Produtos::where('status', '=', $status)->get();



        /**
         * Valida se encontrou registros
         */

        if (is_null($db)) {


            $msg = [
                'tipo' => 'erro',
                'msg' => 'Nenhum produto encontrado'
            ];

            return ResponseController::res404($response, $msg); // Retorna mensagem
        } else {


            $msg = [
                'tipo' => 'sucesso',
                'totalProdutos' => count($db),
                'msg' => $db
            ];

            return ResponseController::res200($response, $msg); // Retorna o resultado
        }
    }

    /**
     * FUNÇÃO QUE BUSCA PEDIDO PELO ID
     */
    public function pedidoPorID(Request $request, Response $response, array $args)
    {
        $msg = [];


        /**
         * Obtem ID do pedido
         */

        $idPedido = $args['id'];



        /**
         * Busca o pedido
         */

        $db = Pedidos::find($idPedido);


        /**
         * Valida se encontrou registros
         */
        if (is_null($db)) {


            $msg = [
                'tipo' => 'erro',
                'msg' => 'Nenhum pedido encontrado'
            ];

            return ResponseController::res400($response, $msg); // Retorna mensagem
        } else {


            $msg = [
                'tipo' => 'sucesso',
                'msg' => $db
            ];

            return ResponseController::res200($response, $msg); // Retorna resultado
        }
    }

    /**
     * FUNÇÃO QUE RETORNA TODAS AS CATEGORIAS
     */
    public function todasCategorias(Request $request, Response $response)
    {
        $msg = [];
        $categorias = [];

        $dbCategoria = Categorias::all();

        foreach ($dbCategoria as $i) {

            $id = $i['id_categoria'];
            $titulo = $i['titulo'];
            $status = $i['status'];

            $subcategoria = SubCategoria::where('id_categoria_principal', '=', $id)
                ->get();

            $categorias[] = [
                'id_principal' => $id,
                'titulo' => $titulo,
                'status' => $status,
                'subcategorias' => $subcategoria
            ];
        }

        $msg = [
            'tipo' => 'sucesso',
            'msg' => $categorias
        ];


        return ResponseController::res200($response, $msg);
    }


    /**
     * FUNÇÃO QUE RETORNA CATEGORIAS ATIVAS
     */
    public function categoriasAtivas(Request $request, Response $response)
    {
        $msg = [];
        $categorias = [];

        $dbCategoria = Categorias::where('status', 1)
            ->get();

        foreach ($dbCategoria as $i) {

            $id = $i['id_categoria'];
            $titulo = $i['titulo'];
            $status = $i['status'];

            $subcategoria = SubCategoria::where('id_categoria_principal', '=', $id)
                ->where('status', 1)
                ->get();

            $categorias[] = [
                'id_principal' => $id,
                'titulo' => $titulo,
                'status' => $status,
                'subcategorias' => $subcategoria
            ];
        }

        $msg = [
            'tipo' => 'sucesso',
            'msg' => $categorias
        ];


        return ResponseController::res200($response, $msg);
    }

    /**
     * FUNÇÃO QUE RETORNA BANNERS
     */
    public function getBanners(Request $request, Response $response)
    {


        $dbFull = Banner::where('tipo', '=', 'full')->get();
        $dbMini = Banner::where('tipo', '=', 'mini')->get();
        $dbMedio = Banner::where('tipo', '=', 'medio')->get();

        $msg = [
            'tipo' => 'sucesso',
            'msg' => [
                'full' => $dbFull,
                'mini' => $dbMini,
                'medio' => $dbMedio
            ]
        ];

        return ResponseController::res200($response, $msg);
    }
}

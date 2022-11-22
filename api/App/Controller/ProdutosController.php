<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Model\Categorias;
use App\Model\Produtos;
use App\Model\SubCategoria;

/**
 *  >>  CLASSE DE PRODUTOS
 */
class ProdutosController
{


    /**
     *  >>  FUNÇÃO QUE EFETUA CADASTRO DO PRODUTO
     */
    public function cadastrarProduto(Request $request, Response $response)
    {

        $msg = [];



        /**
         * Obtem informação da API
         */

        $dataAPI = $request->getParsedBody();

        $tituloProduto = $dataAPI['tituloProduto'] ?? null;
        $descProduto = $dataAPI['descProduto'] ?? null;
        $idCategoria = intval($dataAPI['idCategoria']) ?? null;
        $produtoDestaque = $dataAPI['destaque'];
        $produtoDestaque2 = $dataAPI['destaque_02'];
        $saldo = intval($dataAPI['saldo']) ?? 0;
        $preco = floatval($dataAPI['preco'])  ?? null;
        $status = $dataAPI['status'] ?? false;


        /**
         * Valida se o título foi informado
         */

        if (is_null($tituloProduto)) { // Valida titulo

            $msg = [
                'tipo' => 'erro',
                'msg' => 'Título não informado ou está no formato incorreto'
            ];

            return ResponseController::res400($response, $msg); // Retorna mensagem de erro
        }



        /**
         * Valida se o ID de alguma categoria foi informada
         */

        if (is_null($idCategoria) || empty($idCategoria)) {

            $msg = [
                'tipo' => 'erro',
                'msg' => 'Categoria não foi informada'
            ];

            return ResponseController::res400($response, $msg); // Retorna mensagem de erro
        }



        /**
         * Valida Saldo
         */

        if (!is_integer($saldo)) {

            $msg = [
                'tipo' => 'erro',
                'msg' => 'Saldo está no formato incorreto'
            ];

            return ResponseController::res400($response, $msg); // Retorna mensagem de erro
        }



        /**
         * Valida Preço
         */

        if (!is_float($preco) || is_null($preco)) {

            $msg = [
                'tipo' => 'erro',
                'msg' => 'Preço está no formato incorreto'
            ];

            return ResponseController::res400($response, $msg); // Retorna mensagem de erro
        }



        /**
         * Pesquisa se a categoria está cadastrada no banco
         */

        $validaCategoria = Categorias::where('id_categoria', '=', $idCategoria)->first() ?? null;
        $validaSubCategoria = SubCategoria::where('id_sub', '=', $idCategoria)->first() ?? null;



        /**
         * Valida se a categoria é valida e se está ativa
         */

        if (is_null($validaCategoria) && is_null($validaSubCategoria)) { // Valida retorno


            $msg = [
                'tipo' => 'erro',
                'msg' => 'Categoria inválida'
            ];

            return ResponseController::res400($response, $msg); // Retorna mensagem de erro
        }


        
        /**
         * Grava dados do produto
         */

        $gravaProduto = Produtos::create([
            'titulo' => $tituloProduto,
            'descricao' => $descProduto,
            'categoria' => $idCategoria,
            'status' => $status,
            'destaque' => $produtoDestaque,
            'destaque_2' => $produtoDestaque2
        ]);


        /**
         * Valida se as informações foram gravadas
         */

        if (is_null($gravaProduto)) {

            $msg = [
                'tipo' => 'erro',
                'msg' => 'Erro ao gravar dados do produto'
            ];

            return ResponseController::res400($response, $msg); // Retorna mensagem de erro

        }


        $idProdutoNovo = $gravaProduto['id'];



        /**
         * Grava estoque
         */

        InventarioController::criaRegistroEstoque($idProdutoNovo, $saldo);



        /**
         * Grava preço
         */

        PrecoController::criaRegistroPreco($idProdutoNovo, $preco);




        /**
         * Retorna mensagem
         */

        $msg = [
            'tipo' => 'sucesso',
            'msg' => 'Produto cadastrado',
            'sku' => $idProdutoNovo
        ];

        return ResponseController::res200($response, $msg);
    }



    /**
     *  >>  FUNÇÃO QUE ATUALIZA DADOS DO PRODUTO
     */
    public function atualizarProduto(Request $request, Response $response)
    {
        $msg = [];



        /**
         * Obtem informação da API
         */

        $dataAPI = $request->getParsedBody();

        $idProduto = $dataAPI['idProduto'] ?? null;
        $tituloProduto = $dataAPI['tituloProduto'] ?? null;
        $descProduto = $dataAPI['descProduto'] ?? null;
        $idCategoria = $dataAPI['idCategoria'] ?? null;
        $produtoDestaque = $dataAPI['destaque'] ?? false;
        $produtoDestaque2 = $dataAPI['destaque_02'] ?? false;
        $status = $dataAPI['status'] ?? null;



        /**
         * Pesquisa produto no banco de dados
         */

        $atualizarProduto  = Produtos::find($idProduto);



        /**
         * Valida se existe cadastro para o produto informado
         */

        if (is_null($atualizarProduto)) {


            $msg = [
                'tipo' => 'erro',
                'msg' => 'Produto não encontrado'
            ];

            return ResponseController::res400($response, $msg);
        }


        if (!is_null($tituloProduto)) {

            $atualizarProduto->titulo = $tituloProduto; // Atualiza titulo
        }


        if (!is_null($descProduto)) {

            $atualizarProduto->descricao = $descProduto; // Atualiza descrição
        }


        if (!is_null($idCategoria)) {

            $atualizarProduto->categoria = $idCategoria; // Atualiza categoria
        }


        if (!is_null($produtoDestaque)) {

            $atualizarProduto->destaque = $produtoDestaque; // Atualiza destaque do produto
        }

        if (!is_null($produtoDestaque2)) {

            $atualizarProduto->destaque_2 = $produtoDestaque2; // Atualiza destaque 2 do produto
        }

        if (!is_null($status)) {

            $atualizarProduto->status = $status; // Atualiza status
        }


        $atualizarProduto->save(); // Salva alterações

        $msg = [
            'tipo' => 'sucesso',
            'msg' => 'Produto atualizado'
        ];

        return ResponseController::res200($response, $msg); // Retorna mensagem
    }




    /**
     *  >>  FUNÇÃO QUE MARCA PRODUTO COMO DELETADO
     */

    public function deletarProduto(Request $request, Response $response, array $args): Response
    {
        $msg = [];


        /**
         * Obtem ID produto
         */

        $idProduto = $args['id'];



        /**
         * Procura produto no banco de dados
         */

        $deletarProduto = Produtos::find($idProduto);



        /**
         * Valida se existe cadastro para o produto informado
         */

        if (is_null($deletarProduto)) {


            $msg = [
                'tipo' => 'sucesso',
                'msg' => 'Produto não encontrado'
            ];

            return ResponseController::res400($response, $msg); // Retorna mensagem
        }


        $deletarProduto->deleted_at = date('Y-m-d H:i:s'); // Marca data de exclusão
        $deletarProduto->status = 'Inativo';

        $deletarProduto->save(); // Salva a alteração


        $msg = [
            'tipo' => 'sucesso',
            'msg' => 'Produto deletado'
        ];

        return ResponseController::res200($response, $msg); // Retorna mensagem
    }
}

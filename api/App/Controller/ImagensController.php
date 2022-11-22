<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Model\Imagens;
use App\Model\Produtos;


class ImagensController
{


    /**
     * FUNÇÃO QUE CADASTRA OU ATUALIZA IMAGENS DOS PRODUTOS
     */

    public function salvaImagens(Request $request, Response $response)
    {
        $msg = [];


        /**
         * Obtem dados da API
         */
        $dataImagem = $request->getParsedBody();

        $produto = intval($dataImagem['produto']) ;
        $imagem01 = $dataImagem['img_01'] ?? null;
        $imagem02 = $dataImagem['img_02'] ?? null;
        $imagem03 = $dataImagem['img_03'] ?? null;
        $imagem04 = $dataImagem['img_04'] ?? null;
        $imagem05 = $dataImagem['img_05'] ?? null;
        $imagem06 = $dataImagem['img_06'] ?? null;




        /**
         * Valida se produto existe
         */

        $validaProduto = Produtos::find($produto);

        if (is_null($validaProduto)) {


            $msg = [
                'tipo' => 'erro',
                'msg' => 'Produto ' . $produto . ' não possui cadastro'
            ];


            return ResponseController::res400($response, $msg);
        }




        /**
         * Busca registro de imagem do produto
         */

        $dbImg = Imagens::where('id_produto', '=', $produto)->first();




        /**
         * Valida se existe imagens cadastrada para o produto
         */

        if (is_null($dbImg)) {




            /**
             * Cadastra imagem do produto
             */

            $db = Imagens::create([
                'id_produto' => $produto,
                'img_01' => $imagem01,
                'img_02' => $imagem02,
                'img_03' => $imagem03,
                'img_04' => $imagem04,
                'img_05' => $imagem05,
                'img_06' => $imagem06
            ]);


            $msg = [
                'tipo' => 'sucesso',
                'msg' => 'Imagens salvas com sucesso'
            ];


            return ResponseController::res200($response, $msg);
        }




        /**
         * Atualiza imagens do produto
         */

        $dbImg->img_01 = $imagem01;
        $dbImg->img_02 = $imagem02;
        $dbImg->img_03 = $imagem03;
        $dbImg->img_04 = $imagem04;
        $dbImg->img_05 = $imagem05;
        $dbImg->img_06 = $imagem06;
        $dbImg->save();


        $msg = [
            'tipo' => 'sucesso',
            'msg' => 'Imagens atualizadas'
        ];


        return ResponseController::res200($response, $msg);
    }
}

<?php

namespace App\Controller;

use App\Model\Precos;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class PrecoController
{


    /**
     * FUNÇÃO ESTÁTICA QUE CRIA REGISTRO DE PREÇO
     */
    static public function criaRegistroPreco($idProduto, $preco)
    {
        Precos::create([
            'id_produto' => $idProduto,
            'preco' => $preco
        ]);
    }



    /**
     * FUNÇÃO QUE ATUALIZA PREÇO
     */
    public function atualizaPreco(Request $request, Response $response)
    {

        $msg = [];



        /**
         * Obtem dados da API
         */

        $data = $request->getParsedBody();

        $produto = $data['idProduto'];
        $novoPreco = $data['preco'];



        /**
         * Busca registro de preço do produto
         */
        $db = Precos::where('id_produto', '=', $produto)->first();



        /**
         * Valida se existe registro de preço
         */

        if (is_null($db)) {



            /**
             * Cria registro de preço
             */

            $this->criaRegistroPreco($produto, $novoPreco);


            $msg = [
                'tipo' => 'sucesso',
                'msg' => 'Adicionado registro de preço'
            ];

            return ResponseController::res200($response, $msg); // Retorna mensagem
        }



        /**
         * Atualiza preço do produto
         */

        $db->preco = $novoPreco;
        $db->save();


        $msg = [
            'tipo' => 'sucesso',
            'msg' => 'Preço atualizado'
        ];

        return ResponseController::res200($response, $msg); // Retorna mensagem
    }
}

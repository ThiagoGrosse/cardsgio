<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Model\Inventario;

class InventarioController
{


    /**
     * FUNÇÃO ESTÁTICA QUE CRIA REGISTRO DE ESTOQUE
     */

    static public function criaRegistroEstoque(int $idProduto, int $estoque)
    {
        $db = Inventario::create([
            'id_produto' => $idProduto,
            'saldo' => $estoque
        ]);

        if (is_null($db)) {

            return false;
        } else {

            return true;
        }
    }



    /**
     * FUNÇÃO ESTÁTICA QUE ESTORNA ESTOQUE (ACRESCENTA SALDO)
     */
    static public function estornaEstoque(int $idProduto, int $estoque)
    {
        $db = Inventario::where('id_produto', '=', $idProduto)->first();

        $db->saldo = $db['saldo'] + $estoque;
        $db->save();
    }



    /**
     * FUNÇÃO ESTÁTICA DE REDUZ ESTOQUE
     */

    static public function reduzEstoque(int $idProduto, int $estoque)
    {
        $db = Inventario::where('id_produto', '=', $idProduto)->first();
        $db->saldo = $db['saldo'] - $estoque;
        $db->save();
    }



    
    /**
     * FUNÇÃO QUE ATUALIZA SALDO ESTOQUE
     */

    public function atualizaSaldo(Request $request, Response $response)
    {
        $msg = [];



        /**
         * Obtem dados da API
         */

        $dataSaldo = $request->getParsedBody();

        $idProduto = $dataSaldo['id_produto'];
        $novoSaldo = $dataSaldo['saldo'];




        /**
         * Busca dados de estoque do produto
         */

        $db = Inventario::where('id_produto', '=', $idProduto)->first();




        /**
         * Valida de existe registro de estoque
         */

        if (is_null($db)) {




            /**
             * Chama função que cria registro de estoque
             */
            $this->criaRegistroEstoque($idProduto, $novoSaldo);


            $msg = [
                'tipo' => 'sucesso',
                'msg' => 'Novo estoque adicionado'
            ];

            return ResponseController::res200($response, $msg); // Retorna mensagem
        }




        /**
         * Atualiza saldo de estoque
         */

        $db->saldo = $novoSaldo;
        $db->save();


        $msg = [
            'tipo' => 'sucesso',
            'msg' => 'Saldo de estoque atualizado'
        ];

        return ResponseController::res200($response, $msg); // Retorna mensagem
    }
}

<?php

namespace App\Controller;

use App\Model\Carrinho;
use App\Model\Inventario;
use App\Model\ItensPedidos;
use App\Model\Pedidos;
use App\Model\Produtos;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class PedidosController
{

    /**
     * FUNÇÃO QUE GRAVA NOVOS PEDIDOS
     * ATUALIZA QUANTIDADE VENDIDA DO PRODUTO
     * ATUALIZA SALDO ESTOQUE
     * REMOVE CARRINHO
     */
    public function cadastrarPedido(Request $request, Response $response)
    {
        $msg = [];



        /**
         * Obetem dados da API
         */
        $dataPedido = $request->getParsedBody();

        $nomeCliente = $dataPedido['nomeCliente'] ?? null;
        $emailCliente = $dataPedido['emailCliente'] ?? null;
        $telefoneCliente = $dataPedido['telefoneCliente'] ?? null;
        $valorTotal = $dataPedido['valorTotal'] ?? null;
        $produtos = $dataPedido['produtos'] ?? null;
        $tokenCarrinho = $dataPedido['tokenCarrinho'] ?? null;

        $validaValorTotal = 0; // Variável utilizada para validar valor total do pedido
        $arrayProdutosPedido = [];



        /**
         * Valida se as informações necessárias foram informadas
         */

        if (is_null($nomeCliente)) { // valida nome do cliente


            $msg = [
                'tipo' => 'erro',
                'msg' => 'Necessário informar um nome'
            ];

            return ResponseController::res400($response, $msg); // Retorna mensagem
        }


        if (is_null($emailCliente)) { // valida email do cliente


            $msg = [
                'tipo' => 'erro',
                'msg' => 'Necessário informar um e-mail'
            ];

            return ResponseController::res400($response, $msg); // Retorna mensagem
        }


        if (is_null($telefoneCliente)) { // valida telefone do cliente


            $msg = [
                'tipo' => 'erro',
                'msg' => 'Necessário informar um telefone'
            ];

            return ResponseController::res400($response, $msg); // Retorna mensagem
        }





        /**
         * Valida se o produto existe e se possui saldo
         */

        foreach ($produtos as $item) {


            $dbProduto = Produtos::select('Produtos.status', 'precos.preco')
                ->join('precos', 'Produtos.id', '=', 'precos.id_produto')
                ->where('Produtos.id', '=', $item['idProduto'])
                ->whereNull('deleted_at')
                ->first();

            $dbSaldo = Inventario::where('id_produto', '=', $item['idProduto'])->first();


            if (is_null($dbProduto)) {


                $msg = [
                    'tipo' => 'erro',
                    'msg' => 'Erro ao registrar pedido, produto ' . $item['idProduto'] . ' não encontrado ou inativo'
                ];

                return ResponseController::res400($response, $msg); // Retorna mensagem
            }


            if ($item['quantidade'] > $dbSaldo['saldo'] || is_null($dbSaldo['saldo'])) {


                $msg = [
                    'tipo' => 'erro',
                    'msg' => 'Erro ao registrar pedido, produto ' . $item['idProduto'] . ' não possui saldo suficiente'
                ];

                return ResponseController::res400($response, $msg); // Retorna mensagem
            };


            $calculaTotalProduto = $item['quantidade'] * $dbProduto['preco'];
            $validaValorTotal += $calculaTotalProduto; // Mutiplica quantidade do produto pelo preço e adiciona na variavel validaValorTotal


            $arrayProdutosPedido[] = [
                'idProduto' => $item['idProduto'],
                'qtd' => $item['quantidade'],
                'valorUni' => $dbProduto['preco'],
                'valorTotalProduto' => $calculaTotalProduto
            ];
        }




        /**
         * Valida se os valores estão corretos
         */

        if ($valorTotal != $validaValorTotal) {


            $msg = [
                'tipo' => 'erro',
                'msg' => 'Erro ao registrar pedido, soma dos valores não está correta'
            ];

            return ResponseController::res400($response, $msg); // Retorna mensagem
        }




        /**
         * Grava pedido
         */

        $gravaPedido = Pedidos::create([
            'nome_cliente' => $nomeCliente,
            'email_cliente' => $emailCliente,
            'telefone_cliente' => $telefoneCliente,
            'valor_pedido' => $valorTotal,
            'status' => 'Novo'
        ]);




        /**
         * Pega ID pedido criado
         */

        $idNovoPedido = $gravaPedido['id'];



        foreach ($arrayProdutosPedido as $i) {

            $valorUni = $i['valorUni'];
            $valorTotalProduto = $i['valorTotalProduto'];
            $qt = $i['qtd'];
            $idProduto = $i['idProduto'];



            /**
             * Grava produtos do pedido no banco
             */

            ItensPedidos::create([
                'id_pedido' => $idNovoPedido,
                'id_produto' => $idProduto,
                'qt_produto' => $qt,
                'valor_unitario' => $valorUni,
                'valor_total' => $valorTotalProduto
            ]);



            /**
             * Atualiza quantidade vendida no produto
             */

            $atualizaQtVendida = Produtos::find($idProduto);
            $atualizaQtVendida->qt_vendida = $atualizaQtVendida['qt_vendida'] + $qt;
            $atualizaQtVendida->save();



            /**
             * Atualiza saldo estoque
             */

            InventarioController::reduzEstoque($idProduto, $qt);
        }



        /**
         * Remover carrinho
         */

        CarrinhoController::deletaCarrinho($tokenCarrinho);

        
        
        /**
         * Retorna mensagem com ID pedido
         */
        $msg = [
            'tipo' => 'sucesso',
            'msg' => 'Pedido ' . $idNovoPedido . ' gravado'
        ];

        return ResponseController::res200($response, $msg);
    }



    /**
     * FUNÇÃO QUE ATUALIZA DADOS DO CLIENTE NO PEDIDO
     * NOME
     * EMAIL
     * TELEFONE
     */
    public function atualizarPedido(Request $request, Response $response)
    {
        $msg = [];



        /**
         * Obtem dados da API
         */

        $dataAtualizaPedido = $request->getParsedBody();

        $pedido = $dataAtualizaPedido['pedido'];
        $nome = $dataAtualizaPedido['nomeCliente'];
        $email = $dataAtualizaPedido['emailCliente'];
        $telefone = $dataAtualizaPedido['telefoneCliente'];



        /**
         * Atualiza dados do pedido
         */

        $dbAtualizaPedido = Pedidos::find($pedido);


        if (is_null($dbAtualizaPedido)) {


            $msg = [
                'tipo' => 'erro',
                'msg' => 'Pedido não encontrado'
            ];

            return ResponseController::res400($response, $msg);
        }


        $dbAtualizaPedido->nome_cliente = $nome;
        $dbAtualizaPedido->email_cliente = $email;
        $dbAtualizaPedido->telefone_cliente = $telefone;
        $dbAtualizaPedido->save();


        $msg = [
            'tipo' => 'sucesso',
            'msg' => 'Pedido atualizado'
        ];

        return ResponseController::res200($response, $msg);
    }


    /**
     * FUNÇÃO QUE ATUALIZA STATUS DO PEDIDO
     * REMOVE QUANTIDADE VENDIDA
     * ESTORNA ESTOQUE
     */

    public function statusPedido(Request $request, Response $response)
    {
        $msg = [];



        /**
         * Obtem dados da API
         */
        $dataStatusPedido = $request->getParsedBody();

        $idPedido = $dataStatusPedido['pedido'];
        $status = $dataStatusPedido['status'];



        /**
         * Valida dados informados
         */

        $dbPedido = Pedidos::where('id', '=', $idPedido)->first();


        if (is_null($dbPedido)) {


            $msg = [
                'tipo' => 'erro',
                'msg' => 'Pedido não encontrado'
            ];

            return ResponseController::res400($response, $msg);
        }


        /**
         * Valida se o novo status é aceito pelo sistema
         */
        if ($status == "Cancelado" || $status == "Finalizado") {


            if ($dbPedido['status'] == "Cancelado") { // Valida se o pedido já está cancelado


                $msg = [
                    'tipo' => 'erro',
                    'msg' => 'Não é possível alterar status de pedido cancelado.'
                ];

                return ResponseController::res400($response, $msg);
            }


            /**
             * Verifica se o novo status é cancelado
             */
            if ($status == "Cancelado") {


                // buscar produto e quantidade do pedido
                $dbItemPedido = ItensPedidos::where('id_pedido', '=', $idPedido)->get();


                foreach ($dbItemPedido as $data) {

                    $produto = $data['id_produto'];
                    $qt = $data['qt_produto'];



                    /**
                     * Estorna saldo estoque
                     */

                    InventarioController::estornaEstoque($produto, $qt);



                    /**
                     * Estornar item vendido
                     */

                    $dbProduto = Produtos::find($produto);

                    $dbProduto->qt_vendida = $dbProduto['qt_vendida'] - $qt;
                    $dbProduto->save();
                }



                /**
                 * Atualiza status do pedido para cancelado
                 */

                $dbPedido->status = $status;
                $dbPedido->save();



                /**
                 * Retorna mensagem de sucesso
                 */

                $msg = [
                    'tipo' => 'sucesso',
                    'msg' => 'Status alterado'
                ];

                return ResponseController::res200($response, $msg);
            } else {




                /**
                 * Atualiza status do pedido para finalizado
                 */

                $dbPedido->status = $status;
                $dbPedido->save();



                /**
                 * Retorna mensagem de sucesso
                 */

                $msg = [
                    'tipo' => 'sucesso',
                    'msg' => 'Status alterado'
                ];

                return ResponseController::res200($response, $msg);
            }
        } else {


            $msg = [
                'tipo' => 'erro',
                'msg' => 'Status informado não é aceito pelo sistema'
            ];

            return ResponseController::res400($response, $msg);
        }
    }
}

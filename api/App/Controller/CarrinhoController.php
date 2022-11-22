<?php

namespace App\Controller;

use App\Model\Carrinho;
use App\Model\Inventario;
use App\Model\Precos;
use App\Model\Produtos;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CarrinhoController
{

    /**
     * FUNÇÃO QUE GERA NOVO TOKEN
     */
    public function gerarTokenCarrinho()
    {
        $nBytes = 10;
        $rBytes = random_bytes($nBytes);
        $token = bin2hex($rBytes);

        return $token;
    }


    /**
     * FUNÇÃO QUE DELETA CARRINHO
     */
    static public function deletaCarrinho(string $token)
    {
        $db = Carrinho::where('token', '=', $token)->delete();

        if (is_null($db)) {

            return false;
        } else {

            return true;
        }
    }


    /**
     * FUNÇÃO QUE CRIA, ATUALIZA E REMOVE CARRINHO
     */
    public function salvaCarrinho(Request $request, Response $response)
    {
        $msg = [];


        $data = $request->getParsedBody();

        $token = $data['token'] ?? null;
        $idProduto = $data['sku'];


        if (is_null($token)) {

            $db = Produtos::find($idProduto);

            if ($db) {

                // Pegar preço

                $dbPreco = Precos::where('id_produto', '=', $idProduto)->first();

                // Pegar estoque
                $dbEstoque = Inventario::where('id_produto', '=', $idProduto)->first();


                if (!is_null($dbPreco) && !is_null($dbEstoque)) {
                    if ($dbPreco['preco'] > 0 && $dbEstoque['saldo'] > 1) {

                        $newToken = $this->gerarTokenCarrinho();

                        $criaCarrinho = Carrinho::create([
                            'token' => $newToken,
                            'id_produto' => $idProduto,
                            'quantidade' => 1,
                            'valor_unitario' => $dbPreco['preco'],
                            'valor_total' => $dbPreco['preco']
                        ]);

                        if ($criaCarrinho) {

                            $msg = [
                                'tipo' => 'sucesso',
                                'msg' => $criaCarrinho['token']
                            ];

                            return ResponseController::res200($response, $msg);
                        } else {

                            $msg = [
                                'tipo' => 'erro',
                                'msg' => "Ocorreu um erro ao salvar produto no carrinho"
                            ];

                            return ResponseController::res400($response, $msg);
                        }
                    } else {

                        $msg = [
                            'tipo' => 'erro',
                            'msg' => "Dados do produto não são suficientes para adiciona-lo ao carrinho"
                        ];

                        return ResponseController::res400($response, $msg);
                    }
                }
            }
        } else {

            $buscaDadosToken = Carrinho::where('token', '=', $token)->get();

            foreach ($buscaDadosToken as $i) {

                $sku = $i['id_produto'];

                $dbPreco = Precos::where('id_produto', '=', $sku)->first();
                $preco = $dbPreco['preco'];

                if ($sku === $idProduto) {

                    $novoSaldo = $i['quantidade'] + 1;

                    $i->quantidade = $novoSaldo;
                    $i->valor_unitario = $preco;
                    $i->valor_total = $novoSaldo * $preco;
                    $i->save();

                    if ($i) {

                        $msg = [
                            'tipo' => 'sucesso',
                            'msg' => 'Carrinho atualizado'
                        ];

                        return ResponseController::res200($response, $msg);
                    }
                }
            }

            $dbPreco = Precos::where('id_produto', '=', $idProduto)->first();

            if (!is_null($dbPreco)) {


                $db = Carrinho::create([
                    'token' => $token,
                    'id_produto' => $idProduto,
                    'quantidade' => 1,
                    'valor_unitario' => $dbPreco['preco'],
                    'valor_total' => $dbPreco['preco']
                ]);

                $msg = [
                    'tipo' => 'sucesso',
                    'msg' => 'Produto adicionado ao carrinho'
                ];

                return ResponseController::res200($response, $msg);
            }
        }
    }

    public function removeItem(Request $request, Response $response)
    {
        $msg = [];

        $data = $request->getParsedBody();

        $token = $data['token'];
        $sku = $data['sku'];
        $qt = $data['qt'];
    }
}

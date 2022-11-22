<?php

namespace App\Controller;

use App\Model\Categorias;
use App\Model\SubCategoria;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CategoriasController
{


    /**
     * FUNÇÃO QUE CRIA CATEGORIA
     */
    public function criarCategoria(Request $request, Response $response)
    {
        $msg = [];



        /**
         * Obtem dados da API
         */

        $data = $request->getParsedBody();

        $idCategoriaPrincipal = $data['idCategoriaPrincipal'];
        $titulo = $data['tituloCategoria'];
        $status = $data['statusCategoria'];

        $getMaiorIDsub = [];
        $getMaiorIDsub = [];

        $getMaiorIDcat = Categorias::select('id_categoria')
            ->orderBy('id', 'desc')
            ->first();

        if (is_null($getMaiorIDcat)) {
            $getMaiorIDcat = ['id_categoria' => 0];
        }

        $getMaiorIDsub = SubCategoria::select('id_sub')
            ->orderBy('id', 'desc')
            ->first();

        if (is_null($getMaiorIDsub)) {
            $getMaiorIDsub = ['id_sub' => 0];
        }

        $maiorID = max($getMaiorIDcat['id_categoria'], $getMaiorIDsub['id_sub']) + 1;

        if ($idCategoriaPrincipal == 0) {

            $criaCategoriaPrincipal = Categorias::create([
                "id_categoria" => $maiorID,
                "titulo" => $titulo,
                "status" => $status
            ]);


            if (!empty($criaCategoriaPrincipal)) {

                $msg = [
                    'tipo' => 'sucesso',
                    'msg' => $criaCategoriaPrincipal
                ];


                return ResponseController::res200($response, $msg);
            }
        } else {

            $criaSubcategoria = SubCategoria::create([
                'id_categoria_principal' => $idCategoriaPrincipal,
                'subcategoria' => $titulo,
                'id_sub' => $maiorID,
                'status' => $status
            ]);


            if (!empty($criaSubcategoria)) {

                $msg = [
                    'tipo' => 'sucesso',
                    'msg' => $criaSubcategoria
                ];


                return ResponseController::res200($response, $msg);
            }
        }


        $msg = [
            'tipo' => 'erro',
            'msg' => 'Erro ao criar categoria'
        ];


        return ResponseController::res400($response, $msg);
    }



    /**
     * FUNÇÃO QUE ATUALIZA DADOS DA CATEGORIA
     */
    public function atualizarCategoria(Request $request, Response $response)
    {
        $msg = [];



        /**
         * Obtem dados da API
         */

        $data = $request->getParsedBody();

        $idCategoria = $data['idCategoria'];
        $titulo = $data['tituloCategoria'];
        $status = $data['statusCategoria'];


        $db = Categorias::find($idCategoria);

        if (empty($db)) {

            $db = SubCategoria::where('id_sub', '=', $idCategoria)->first();

            if (!empty($db)) {

                $db->subcategoria = $titulo;
                $db->status = $status;
                $db->save();

                $msg = [
                    'tipo' => 'sucesso',
                    'msg' => 'Categoria atualizada com sucesso'
                ];

                return ResponseController::res200($response, $msg);
            }
        } else {

            $db->titulo = $titulo;
            $db->status = $status;
            $db->save();

            $msg = [
                'tipo' => 'sucesso',
                'msg' => 'Categoria atualizada com sucesso'
            ];

            return ResponseController::res200($response, $msg);
        }

        $msg = [
            'tipo' => 'erro',
            'msg' => 'Ocorreu um erro ao tentar atualizar a categoria'
        ];

        return ResponseController::res400($response, $msg);
    }



    /**
     * FUNÇÃO QUE DELETA CATEGORIA
     */
    public function deletarCategoria(Request $request, Response $response, array $args)
    {
        $msg = [];



        /**
         * Obtem ID da categoria
         */

        $idCategoria = $args['id'];



        /**
         * Deleta categoria
         */

        $db = SubCategoria::where('id_sub', '=', $idCategoria)->first();

        if ($db) {

            $db->delete();

            $msg = [
                'tipo' => 'sucesso',
                'msg' => 'Categoria excluída'
            ];


            return ResponseController::res200($response, $msg); // Retorna mensagem
        } else {

            $db = Categorias::find($idCategoria);
            $db->delete();

            $deleteSub = SubCategoria::where('id_categoria_principal', '=', $idCategoria)->get();

            if (empty($deleteSub)) {

                die(json_encode('deleteSub'));

                $deleteSub->delete();

                $msg = [
                    'tipo' => 'sucesso',
                    'msg' => 'Categoria excluída'
                ];


                return ResponseController::res200($response, $msg); // Retorna mensagem
            } else {

                if ($db) {

                    $msg = [
                        'tipo' => 'sucesso',
                        'msg' => 'Categoria excluída'
                    ];


                    return ResponseController::res200($response, $msg); // Retorna mensagem
                } else {
                    $msg = [
                        'tipo' => 'erro',
                        'msg' => 'Não foi possível excluír a categoria'
                    ];


                    return ResponseController::res400($response, $msg); // Retorna mensagem
                }
            }
        }
    }
}

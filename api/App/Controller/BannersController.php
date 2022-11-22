<?php

namespace App\Controller;

use App\Model\Banner;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BannersController
{


    /**
     * FUNÇÃO QUE GRAVA OU ATUALIZA DADOS DO BANNER
     */

    public function gravaBanner(Request $request, Response $response)
    {
        $msg = [];



        /**
         * Obtem dados da API
         */

        $data = $request->getParsedBody();


        $tipo = $data['tipo'] ?? null;
        $ordem = $data['ordem'] ?? null;
        $diretorio = $data['nomeImagem'] ?? null;
        $link = $data['link'] ?? null;

        /**
         * Busca dados do banner
         */

        $db = Banner::where('tipo', '=', $tipo)
            ->where('ordem', '=', $ordem)
            ->first();


        /**
         * Valida se existe registro para o tipo de banner informado
         */


        if (is_null($db)) {


            /**
             * Cria registro do banner
             */

            $criaRegistroBanner = Banner::create([
                'tipo' => $tipo,
                'ordem' => $ordem,
                'diretorio' => $diretorio,
                'link' => $link
            ]);


            if (!is_null($criaRegistroBanner)) {


                $msg = [
                    'tipo' => 'sucesso',
                    'msg' => 'Banner adicionado com sucesso'
                ];

                return ResponseController::res200($response, $msg); // Retorna mensagem
            } else {


                $msg = [
                    'tipo' => 'erro',
                    'msg' => 'Erro ao salvar dados do banner'
                ];

                return ResponseController::res200($response, $msg); // Retorna mensagem
            }
        } else {



            /**
             * Atualiza dados do banner
             */

            $db->tipo = $tipo;
            $db->ordem = $ordem;
            $db->diretorio = $diretorio;
            $db->link = $link;
            $db->save();


            $msg = [
                'tipo' => 'sucesso',
                'msg' => 'Dados do banner atualizado'
            ];

            return ResponseController::res200($response, $msg); // Retorna mensagem
        }
    }
}

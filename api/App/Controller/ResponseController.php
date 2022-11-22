<?php

namespace App\Controller;

class ResponseController
{
    public static function res200($response, array $msg)
    {
        $response->getBody()->write(json_encode($msg));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public static function res404($response, array $msg)
    {
        $response->getBody()->write(json_encode($msg));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
    }

    public static function res400($response, array $msg)
    {
        $response->getBody()->write(json_encode($msg));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }
}

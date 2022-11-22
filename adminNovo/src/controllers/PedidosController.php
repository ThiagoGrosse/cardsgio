<?php

namespace src\controllers;

use \core\Controller;

class PedidosController extends Controller
{

    public function index()
    {
        $this->render('pedidos');
    }

}

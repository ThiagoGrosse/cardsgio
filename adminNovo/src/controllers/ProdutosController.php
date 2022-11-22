<?php

namespace src\controllers;

use \core\Controller;

class ProdutosController extends Controller
{

    public function index()
    {
        $this->render('produtos');
    }

}

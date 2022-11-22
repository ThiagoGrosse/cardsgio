<?php

namespace src\controllers;

use \core\Controller;

class ProdutosController extends Controller
{

    public function index()
    {
        $this->render('produtos');
    }

    public function produtoID()
    {
        $this->render('produto');
    }

    public function categoriasID()
    {
        $this->render('categoria');
    }
}

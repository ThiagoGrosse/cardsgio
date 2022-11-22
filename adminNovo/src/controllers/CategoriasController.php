<?php

namespace src\controllers;

use \core\Controller;

class CategoriasController extends Controller
{

    public function index()
    {
        $this->render('categorias');
    }
}

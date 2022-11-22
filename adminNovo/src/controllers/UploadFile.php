<?php

namespace src\controllers;

use \core\Controller;

class UploadFile extends Controller
{
    public function index()
    {
        $this->render('uploadfile', ['item' => $_FILES, $_POST]);
    }
}

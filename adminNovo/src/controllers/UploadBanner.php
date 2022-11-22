<?php

namespace src\controllers;

use \core\Controller;

class UploadBanner extends Controller
{
    public function index()
    {
        $this->render('uploadBanner', ['banner' => $_FILES, $_POST]);
    }
}

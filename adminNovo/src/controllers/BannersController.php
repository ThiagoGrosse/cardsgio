<?php

namespace src\controllers;

use \core\Controller;

class BannersController extends Controller
{

    public function index()
    {
        $this->render('banners');
    }
}

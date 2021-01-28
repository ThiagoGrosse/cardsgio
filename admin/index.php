<?php

require "helper/classUrl.php";

$modulo = Url::getURL(0);

if ($modulo == null) {
    $modulo = "index";
}

if (file_exists("pages/" . $modulo . ".php")) {
    require "pages/" . $modulo . ".php";
} else {
    require "pages/404.php";
}

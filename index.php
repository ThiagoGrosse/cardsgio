<?php

require "app/helper/Url.php";

$modulo = Url::getURL(0);

if ($modulo == null) {
    $modulo = "index";
}

if (file_exists("app/" . $modulo . ".php")) {
    require "app/" . $modulo . ".php";
} else {
    require "app/404.php";
}
<?php
session_start();
session_destroy();

header('Location: '.URL::getBase() . 'logout');
clearstatcache();
die();

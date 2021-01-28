<?php

function dbON(){
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $db = 'cards_do_gio';

    $conn = new mysqli($host, $user, $password, $db);

    if ($conn -> connect_errno) {
        echo "Failed to connect to MySQL: " . $conn -> connect_error;
        exit();
    }
    return $conn;
}
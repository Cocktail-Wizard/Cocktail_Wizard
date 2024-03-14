<?php

require "connexion.php";

$request = $_SERVER['REQUEST_URI'];

if (isset($_SERVER['REQUEST_METHOD'])) {
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        require "get.php";
    }

    if ($_SERVER['REQUEST_METHOD'] == "PUT") {
        echo "PUT METHOD!";
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        echo "POST METHOD!";
    }
}

$con->close();

?>

<?php

require_once __DIR__ . "/../api/connexion.php";

if ($success) {
    session_start();
    setcookie("username", $nom, 0, "/");
}

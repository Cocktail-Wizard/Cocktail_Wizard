<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $src = 'web';

    require_once __DIR__ . "/../api/connexion.php";


    if ($success) {
        $_SESSION['username'] = $nom;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $_SESSION = array();
    session_destroy();
}

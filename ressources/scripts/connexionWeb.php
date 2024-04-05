<?php

require_once __DIR__ . "/../api/connexion.php";

if ($success) {
    session_start();
    $_SESSION['username'] = $nom;
    setcookie('username', $nom, 0, '/', "", null, false);
}

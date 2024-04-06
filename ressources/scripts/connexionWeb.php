<?php
session_start();

require_once __DIR__ . "/../api/connexion.php";


if ($success) {
    $_SESSION['username'] = $nom;
}

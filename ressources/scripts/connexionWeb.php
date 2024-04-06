<?php
session_start();

require_once __DIR__ . "/../api/connexion.php";

$cookie_domain = "";
$cookie_secure = 0; // Transmit cookie over HTTPS
$cookie_http_only = 0; // Access through JavaScript

if ($success) {
    $_SESSION['username'] = $nom;
    setcookie('username', $nom, 0, '/', $cookie_domain, $cookie_secure, $cookie_http_only);
}

echo json_encode($response);

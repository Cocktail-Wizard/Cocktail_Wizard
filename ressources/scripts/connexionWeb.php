<?php

require_once __DIR__ . "/../api/connexion.php";

$cookie_domain = ""; // Set to your domain if needed
$cookie_secure = true; // Only transmit cookie over HTTPS
$cookie_http_only = true; // Prevent cookie from being accessed through JavaScript

if ($success) {
    session_start();
    $_SESSION['username'] = $nom;
    setcookie('username', $nom, 0, '/', $cookie_domain, $cookie_secure, $cookie_http_only);
}

<?php
session_start();

require_once __DIR__ . "/../api/connexion.php";

$cookie_domain = ""; // Set to your domain if needed
$cookie_secure = true; // Only transmit cookie over HTTPS
$cookie_http_only = false; // Prevent cookie from being accessed through JavaScript

if ($success) {
    $_SESSION['username'] = $nom;
    setcookie('username', $nom, 0, '/', $cookie_domain, $cookie_secure, $cookie_http_only);
}

echo json_encode($response);

<?php
session_start();
if (!isset($_SESSION['username'])) {
    galerieNonConnecte();
} else {
    galerieConnecte();
}

function galerieNonConnecte()
{
    require_once "pages/galerie.php";
}

function galerieConnecte()
{
    require_once "pages/galerieConn.php";
}

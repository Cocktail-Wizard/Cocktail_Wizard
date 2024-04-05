<?php
session_start();
if (!isset($_SESSION['username'])) {
    require_once "pages/galerie.php";
} else {
    $nom = $_SESSION['username'];
    require_once "pages/galerie_connecte.php";
}

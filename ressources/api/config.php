<?php
// Définir les constantes pour les informations sensibles de la base de données
define('DB_HOST', 'cocktailwizbd.mysql.database.azure.com');
define('DB_USER', 'cocktail');
define('DB_PASSWORD', 'Cw-yplmv');
define('DB_NAME', 'nom_de_votre_base_de_donnees');

// Créer la connexion à la base de données directement
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données: " . $conn->connect_error);
}

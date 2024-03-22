<?php
function connexionBD(){
    // Charger les variables d'environnement depuis le fichier .env
    //$env = parse_ini_file('../../.env');

    // Définir les constantes pour les informations sensibles de la base de données
    /*
    define('DB_HOST', $env['DB_HOST']);
    define('DB_USER', $env['DB_USER']);
    define('DB_PASSWORD', $env['DB_PASSWORD']);
    define('DB_NAME', $env['DB_NAME']);
    */
    // Créer la connexion à la base de données directement
    $conn = new mysqli('cocktailwizbd.mysql.database.azure.com', 'cocktail', 'Cw-yplmv', 'cocktailwizardbd');

    if ($conn->connect_error) {
        return null;
    }

    return $conn;
}
?>

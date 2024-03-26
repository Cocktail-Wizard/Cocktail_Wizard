<?php
function connexionBD(): ?mysqli
{
    require_once(__DIR__ . '/configDonne.php');

    // Créer la connexion à la base de données directement
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

    if ($conn->connect_error !== null) {
        return null;
    }

    return $conn;
}

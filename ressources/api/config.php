
<?php
/**
 * Fonction connexionBD
 *
 * Fonction qui permet de se connecter à la base de données. Fait appel au fichier configDonne.php
 * qui contient les informations de connexion à la base de données. Il se situe dans le fichier parent
 * du root du projet afin de ne pas être accessible dans le github.
 *
 * @return mysqli|null Retourne la connexion à la base de données ou null si la connexion a échoué
 *
 * @version 1.3
 *
 * @author Maxim Dmitriev, Vianney Veremme, Yani Amellal
 */

function connexionBD(): ?mysqli
{
    require_once(__DIR__ . '/../../../configDonne.php');

    // Créer la connexion à la base de données directement
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

    if ($conn->connect_error !== null) {
        return null;
    }

    return $conn;
}

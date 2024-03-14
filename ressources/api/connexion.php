<?php
    function connexion($hostname, $identifiant, $mot_de_passe) {

        // Établir la connexion avec MySQLi
        $conn = new mysqli($hostname, $identifiant, $mot_de_passe);

        // Retourner une valeur vide en cas d'échec de connexion
        if ($conn->connect_error) {
            return null;
        }

        return $conn;
    }
?>

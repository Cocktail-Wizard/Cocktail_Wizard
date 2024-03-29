<?php

/**
 * Fonction usernameToId
 *
 * Cette fonction permet de retourner l'id d'un utilisateur en fonction de son nom d'utilisateur.
 *
 *
 * @param String $username Le nom d'utilisateur de l'utilisateur
 * @param mysqli $conn La connexion à la base de données
 * @param Boolean $sqliEsacpeNecessaire Détermine si l'échappement SQL est nécessaire.
 *                 Par défaut, il est activé. L'échappement SQL ne doit pas être activé si le username
 *                 est passé en JSON et que la fonction paramJSONvalide a été utilisé sur celui-ci.
 *
 * @return Cocktail L'objet Cocktail rempli avec les informations du cocktail
 *
 * @see paramJSONvalide.php
 *
 * @author Yani Amellal
 *
 * @version 1.0
 *
 */
function usernameToId($username, $conn)
{

    try {
        // Envoie une requête à la base de données pour obtenir l'id de l'utilisateur en fonction
        // de son nom d'utilisateur
        $username = trim($username);    // Enlève les espaces inutiles
        $requete_preparee = $conn->prepare("CALL GetIdUser(?)");
        $requete_preparee->bind_param("s", $username);
        $requete_preparee->execute();
        $resultat = $requete_preparee->get_result();
        $requete_preparee->close();

        // Si l'utilisateur n'existe pas, retourne une erreur 404
        if ($resultat->num_rows == 1) {
            $row = $resultat->fetch_assoc();
            $id_user = $row['id_utilisateur'];
        } else {
            http_response_code(404);
            echo json_encode("Aucun utilisateur n'a été trouvé avec ce nom d'utilisateur.");
            exit();
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode("Erreur :" . $e->getMessage());
        exit();
    }

    return $id_user; // Retourne l'id de l'utilisateur
}

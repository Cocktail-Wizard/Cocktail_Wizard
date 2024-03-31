<?php

/**
 * Fonction usernameToId
 *
 * Cette fonction permet de retourner l'id d'un utilisateur en fonction de son nom d'utilisateur.
 *
 *
 * @param String $username Le nom d'utilisateur de l'utilisateur
 * @param mysqli $conn La connexion à la base de données
 *
 * @return Cocktail L'objet Cocktail rempli avec les informations du cocktail
 *
 * @author Yani Amellal
 *
 * @version 1.0
 * @date Mars 2024
 */
function usernameToId($username, $conn)
{

    $username_s = mysqli_real_escape_string($conn, $username);
    try {
        // Envoie une requête à la base de données pour obtenir l'id de l'utilisateur en fonction
        // de son nom d'utilisateur
        $requete_preparee = $conn->prepare("CALL GetIdUser(?)");
        $requete_preparee->bind_param("s", $username_s);
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

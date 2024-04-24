<?php

/**
 * Script dislikeCommentaire
 *
 * Script de l'API qui permet de retirer un like à un commentaire.
 *
 * Type de requête : DELETE
 *
 * URL : /api/cocktails/commentaires/like
 *
 * @param JSON : username, id_commentaire
 *
 * @return JSON Le nouveau nombre de like du cocktail
 *
 * @version 1.0
 *
 * @author Yani Amellal
 */

header('Content-Type: application/json');
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/fonctionAPIphp/usernameToId.php';
require_once __DIR__ . '/fonctionAPIphp/paramJSONvalide.php';
require_once __DIR__ . '/fonctionAPIphp/authorisationAPI.php';

$conn = connexionBD();

$donnees = json_decode(file_get_contents('php://input'), true);

// Vérifie si les paramètres sont présents et les échappe
$username = paramJSONvalide($donnees, 'username');
$id_commentaire = paramJSONvalide($donnees, 'id_commentaire');

userAccesResssource($username);
$userId = usernameToId($username, $conn);


try {
    // Envoie une requête à la base de données pour enlever un like au commentaire
    $requete_preparee = $conn->prepare("CALL DislikeCocktail(?,?)");
    $requete_preparee->bind_param('ii', $userId, $id_commentaire);
    $requete_preparee->execute();
    $resultat = $requete_preparee->get_result();
    $requete_preparee->close();

    // Récupère le nombre de like du commentaire
    if ($resultat->num_rows == 1) {
        $row = $resultat->fetch_assoc();
        $nbLike['nb_like'] = $row['nb_like'];

        echo json_encode($nbLike);
    } else {
        http_response_code(404);
        echo json_encode("Erreur : le commentaire n'existe pas ou l'utilisateur n'a pas liké ce commentaire.");
        exit();
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode("Erreur : " . $e->getMessage());
    exit();
}

$conn->close();

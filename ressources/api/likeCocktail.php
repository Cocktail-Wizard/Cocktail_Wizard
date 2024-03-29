<?php

/**
 * Script likeCocktail
 *
 * Script de l'API qui permet de liker un cocktail.
 *
 * Type de requête : POST
 *
 * URL : /api/cocktails/like
 *
 * @param JSON : username, id_cocktail
 *
 * @return JSON Le nouveau nombre de like du cocktail
 *
 * @version 1.1
 *
 * @author Yani Amellal
 */

header('Content-Type: application/json');
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/fonctionAPIphp/usernameToId.php';

$conn = connexionBD();

$donnees = json_decode(file_get_contents('php://input'), true);
$id_cocktail = paramJSONvalide($donnees, 'id_cocktail');
$username = paramJSONvalide($donnees, 'username');
$userId = usernameToId($username, $conn);

try {
    // Envoie une requête à la base de données pour ajouter un like au cocktail et
    // récupérer le nouveau nombre de like
    $requete_preparee = $conn->prepare("CALL LikeCocktail(?,?)");
    $requete_preparee->bind_param('ii', $id_cocktail, $userId);
    $requete_preparee->execute();
    $resultat = $requete_preparee->get_result();
    $requete_preparee->close();

    if ($resultat->num_rows == 1) {
        $row = $resultat->fetch_assoc();
        $nbLike['nb_like'] = $row['nb_like'];

        echo json_encode($nbLike);
    } else {
        http_response_code(404);
        echo json_encode("Erreur");
        exit();
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode("Erreur : " . $e->getMessage());
    exit();
}

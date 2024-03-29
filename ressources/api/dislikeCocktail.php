<?php

/**
 * Script dislikeCocktail
 *
 * Script de l'API qui permet de retirer un like à un cocktail.
 *
 * Type de requête : DELETE
 *
 * URL : /api/cocktails/like
 *
 * @param JSON : username, id_cocktail
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

$conn = connexionBD();

$donnees = json_decode(file_get_contents('php://input'), true);

// Vérifie si les paramètres sont présents et les échappe
$username = paramJSONvalide($donnees, 'username');
$id_cocktail = paramJSONvalide($donnees, 'id_cocktail');
$userId = usernameToId($username, $conn);

try {
    // Envoie une requête à la base de données pour enlever un like au cocktail
    $requete_preparee = $conn->prepare("CALL DislikeCocktail(?,?)");
    $requete_preparee->bind_param('ii', $id_cocktail, $userId);
    $requete_preparee->execute();
    $resultat = $requete_preparee->get_result();
    $requete_preparee->close();

    // Récupère le nombre de like du cocktail
    if ($resultat->num_rows == 1) {
        $row = $resultat->fetch_assoc();
        $nbLike['nb_like'] = $row['nb_like'];

        echo json_encode($nbLike);
    } else {
        http_response_code(404);
        echo json_encode("Erreur: le cocktail n'existe pas ou l'utilisateur n'a pas liké ce cocktail.");
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode("Erreur : " . $e->getMessage());
    exit();
}
$conn->close();

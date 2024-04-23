<?php

/**
 * Script supprimerProfile
 *
 * Script de l'API qui permet de supprimer un compte utilisateur de la base de données.
 *
 * Type de requête : DELETE
 *
 * URL : /api/users
 *
 * @param JSON : username
 *
 */
header("content-type: application/json");
require_once(__DIR__ . "/config.php");
require_once(__DIR__ . "/fonctionAPIphp/paramJSONvalide.php");
require_once(__DIR__ . "/fonctionAPIphp/usernameToId.php");
require_once(__DIR__ . "/fonctionAPIphp/authorisationAPI.php");

$conn = connexionBD();

$donnee = json_decode(file_get_contents("php://input"), true);
$username = paramJSONvalide($donnee, "username");

userAccesResssource($username);
$userID = usernameToId($username, $conn);

try {
    $requete_preparee = $conn->prepare("CALL SupprimerCompte(?)");
    $requete_preparee->bind_param("i", $userID);
    $requete_preparee->execute();
    $resultat = $requete_preparee->get_result();
    $requete_preparee->close();

    if ($resultat->num_rows > 0) {
        $row = $resultat->fetch_assoc();
        echo json_encode($row['success']);
    } else {
        http_response_code(404);
        echo json_encode("Erreur lors de la suppression du commentaire");
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode("Erreur : " . $e->getMessage());
}

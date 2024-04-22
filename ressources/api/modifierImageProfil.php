<?php

/**
 * Script modifierImageProfil
 *
 * Script de l'API qui permet de modifier l'image de profil d'un utilisateur.
 * Lorsque cette route est appeler l'image de l'utilisateur est remplacé par la prochaine image
 * disponible dans la liste des images de profil.
 *
 * Type de requête : PATCH
 *
 * URL : /api/users/image
 *
 * @param JSON $username Le nom d'utilisateur de l'utilisateur.
 *
 * @return JSON Un json contenant le nouveau nom de l'image de profil.
 */

header("Content-Type: application/json");
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/fonctionAPIphp/usernameToId.php';
require_once __DIR__ . '/fonctionAPIphp/paramJSONvalide.php';

$conn = connexionBD();

$donnee = json_decode(file_get_contents('php://input'), true);

$username = paramJSONvalide($donnee, 'username');

$id_user = usernameToId($username, $conn);

try {
    // Envoie une requête à la base de données pour modifier l'image de profil de l'utilisateur
    $requete_preparee = $conn->prepare("CALL changerImageUtilisateur(?)");
    $requete_preparee->bind_param('i', $id_user);
    $requete_preparee->execute();
    $resultat = $requete_preparee->get_result();
    $requete_preparee->close();

    if ($resultat->num_rows == 1) {
        $row = $resultat->fetch_assoc();
        $image['image'] = $row['img'];

        echo json_encode($image);
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

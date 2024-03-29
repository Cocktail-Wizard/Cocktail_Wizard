<?php

/**
 * Script likeCommentaire
 *
 * Script de l'API qui permet de liker un commentaire d'un post.
 *
 * Type de requête : POST
 *
 * URL : /api/cocktails/commentaires/like
 *
 * @param JSON : username, id_commentaire
 *
 * @return JSON Le nouveau nombre de like du commentaire
 *
 * @version 1.1
 *
 * @author Yani Amellal
 */

header('Content-Type: application/json');
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/fonctionAPIphp/usernameToId.php';
require_once __DIR__ . '/fonctionAPIphp/paramJSONvalide.php';

$conn = connexionBD();

$donnees = json_decode(file_get_contents('php://input'), true);
$id_commentaire = paramJSONvalide($donnees, 'id_commentaire');
$username = paramJSONvalide($donnees, 'username');
$userId = usernameToId($username, $conn);

try {
    $requete_preparee = $conn->prepare("CALL LikeCommentaire(?,?)");
    $requete_preparee->bind_param('ii', $id_commentaire, $userId);
    $requete_preparee->execute();
    $resultat = $requete_preparee->get_result();
    $requete_preparee->close();

    if ($resultat->num_rows == 1) {
        $row = $resultat->fetch_assoc();
        $nbLike["nouvNbLike"] = $row['nb_like'];

        echo json_encode($nbLike);
    } else {
        http_response_code(404);
        echo json_encode("Erreur");
        exit();
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode("Une erreur s'est produite : " . $e->getMessage());
    exit();
}

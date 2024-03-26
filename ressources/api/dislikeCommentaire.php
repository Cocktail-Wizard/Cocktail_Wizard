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
require_once __DIR__ .'/fonctionAPIphp/usernameToId.php';

$conn = connexionBD();

if($conn == null){
    http_response_code(500);
    echo json_encode("Erreur de connexion à la base de données.");
    exit();
}

$donnees = json_decode(file_get_contents('php://input'), true);

$userId = usernameToId(trim($donnees['username']), $conn);
$id_commentaire = mysqli_real_escape_string($conn, trim($donnees['id_comemntaire']));

$requete_preparee = $conn->prepare("CALL DislikeCocktail(?,?)");
$requete_preparee->bind_param('ii', $userId, $id_commentaire);
$requete_preparee->execute();
$resultat = $requete_preparee->get_result();
$requete_preparee->close();

if($resultat->num_rows == 1){
    $row = $resultat->fetch_assoc();
    $nbLike = $row['nb_Like'];

    echo json_encode($nbLike);
}
else{
    http_response_code(404);
    echo json_encode("Erreur");
    exit();
}

$conn->close();

?>

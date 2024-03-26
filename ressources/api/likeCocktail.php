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
require_once __DIR__ .'/fonctionAPIphp/usernameToId.php';

$conn = connexionBD();

if($conn == null){
    http_response_code(500);
    echo json_encode("Erreur de connexion à la base de données.");
    exit();
}

$donnees = json_decode(file_get_contents('php://input'), true);
$id_cocktail = mysqli_real_escape_string($conn, trim($donnees['id_cocktail']));
$userId = usernameToId(trim($donnees['username']), $conn);

// Envoie une requête à la base de données pour ajouter un like au cocktail et
// récupérer le nouveau nombre de like
$requete_preparee = $conn->prepare("CALL LikeCocktail(?,?)");
$requete_preparee->bind_param('ii', $userId, $id_cocktail);
$requete_preparee->execute();
$resultat = $requete_preparee->get_result();
$requete_preparee->close();

if($resultat->num_rows == 1){
    $row = $resultat->fetch_assoc();
    $nbLike = $row['nb_like'];

    echo json_encode($nbLike);
}
else{
    http_response_code(404);
    echo json_encode("Erreur");
    exit();
}
?>

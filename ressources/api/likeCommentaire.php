<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ .'/fonctionAPIphp/usernameToId.php';

$conn = connexionBD();

if($conn == null){
    http_response_code(500);
    echo json_encode("Erreur de connexion à la base de données.");
    exit();
}

$id_cocktail = mysqli_real_escape_string($conn, $_POST['id_cocktail']);
$username = mysqli_real_escape_string($conn, $_POST['username']);
$userId = usernameToId($username, $conn);

$requete_preparee = $conn->prepare("CALL LikeCommentaire(?,?)");
$requete_preparee->bind_param('ii', $userId, $id_cocktail);
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

?>

<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ .'/fonctionAPIphp/usernameToId.php';

$conn = connexionBD();

if($conn == null){
    http_response_code(500);
    echo json_encode("Erreur de connexion à la base de données.");
    exit();
}

$nomIngredient = mysqli_real_escape_string($conn, $_POST['nomIngredient']);
$typeIngredient = mysqli_real_escape_string($conn, $_POST['typeIngredient']);
$username = mysqli_real_escape_string($conn, $_POST['username']);
$userId = usernameToId($username, $conn);

$requete_preparee = $conn->prepare("CALL AjouterIngredient(?,?,?)");
$requete_preparee->bind_param('iss', $userId, $nomIngredient, $typeIngredient);
$requete_preparee->execute();
$resultat = $requete_preparee->get_result();
$requete_preparee->close();

if($resultat->num_rows > 0){
    while($row = $resultat->fetch_assoc()){
        $ingredients[] = $row['nom'];
    }

    echo json_encode($ingredients);
}

$conn->close();
?>

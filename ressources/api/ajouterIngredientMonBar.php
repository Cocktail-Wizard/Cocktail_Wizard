<?php

/**
 * Script ajouterIngredientMonBar
 *
 * Script de l'API qui permet d'ajouter un ingredient au bar de l'utilisateur.
 *
 * Type de requête : POST
 *
 * URL : /api/ingredients
 *
 * @param FormData : nomIngredient, username.
 *
 * @return JSON Un json contenant la liste mise à jour des ingredients du bar de l'utilisateur.
 *
 * @version 1.2
 *
 * @author Yani Amellal
 */
header('Content-Type: application/json');
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/fonctionAPIphp/usernameToId.php';

$conn = connexionBD();

$ingredients = [];

if ($conn == null) {
    http_response_code(500);
    echo json_encode("Erreur de connexion à la base de données.");
    exit();
}
// Récupère les données envoyées par le client
$donnee = json_decode(file_get_contents('php://input'), true);

$nomIngredient = mysqli_real_escape_string($conn, trim($donnee['nomIngredient']));
$userId = usernameToId(trim($donnee['username']), $conn);

// Envoie une requête à la base de données pour ajouter l'ingredient au bar de l'utilisateur
$requete_preparee = $conn->prepare("CALL AjouterIngredient(?,?)");
$requete_preparee->bind_param('is', $userId, $nomIngredient);
$requete_preparee->execute();
$resultat = $requete_preparee->get_result();
$requete_preparee->close();

if ($resultat->num_rows > 0) {
    $ingredients = array();

    while ($row = $resultat->fetch_assoc()) {
        $ingredients[] = $row['nom'];
    }

    echo json_encode($ingredients);
} else {

    echo json_encode("Aucun ingredient trouvé.");
}

$conn->close();

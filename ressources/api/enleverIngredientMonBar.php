<?php

/**
 * Script enleverIngredientMonBar
 *
 * Script de l'API qui permet de retirer un ingrédient du bar d'un utilisateur.
 *
 * Type de requête : DELETE
 *
 * URL : /api/users/ingredients
 *
 * @param JSON : nomIngredient, username.
 *
 * @return JSON La liste des ingrédients du bar de l'utilisateur
 *
 * @version 1.1
 *
 * @author Léonard Marcoux, Yani Amellal
 */

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405); // Méthode non autorisée
    echo json_encode("Seules les requêtes de type DELETE sont autorisées.");
    exit();
}

header('Content-Type: application/json');
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/fonctionAPIphp/usernameToId.php';

//s'assurer que on delete le bon ingredient du bon utilisateur
$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['nomIngredient']) || !isset($data['username'])) {
    http_response_code(400);
    echo json_encode("Paramètres manquants.");
    exit();
}

$conn = connexionBD();

if ($conn == null) {
    http_response_code(500);
    echo json_encode("Erreur de connexion à la base de données.");
    exit();
}

$nomIngredient = mysqli_real_escape_string($conn, $data['nomIngredient']);
$userId = usernameToId($data['username'], $conn);

$requete_preparee = $conn->prepare("CALL RetraitIngredient(?,?)");
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

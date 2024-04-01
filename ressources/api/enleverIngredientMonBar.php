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

header('Content-Type: application/json');
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/fonctionAPIphp/usernameToId.php';
require_once __DIR__ . '/fonctionAPIphp/paramJSONvalide.php';

$conn = connexionBD();

//s'assurer que on delete le bon ingredient du bon utilisateur
$donnees = json_decode(file_get_contents("php://input"), true);

$nomIngredient = paramJSONvalide($donnees, 'nomIngredient');
$username = paramJSONvalide($donnees, 'username');
$userId = usernameToId($username, $conn);

try {

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
        http_response_code(204);
        echo json_encode("Aucun ingredient trouvé.");
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode("Erreur : " . $e->getMessage());
}
$conn->close();

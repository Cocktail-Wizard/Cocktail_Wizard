<?php

/**
 * Script getUserIngredients
 *
 * Script de l'API qui permet de récupérer la liste des ingrédients qu'un utilisateur possède.
 * Pour MonBar.
 *
 * Type de requête : GET
 *
 * URL : /api/users/$username/ingredients
 *
 * @param string $username Le nom d'utilisateur de l'utilisateur.
 *
 * @return JSON La liste des ingrédients de l'utilisateur.
 *
 * @version 1.0
 *
 * @author Yani Amellal
 */

header('Content-Type: application/json');
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/fonctionAPIphp/usernameToId.php';
require_once __DIR__ . '/fonctionAPIphp/authorisationAPI.php';

// Connexion à la base de données
$conn = connexionBD();

//Liste des noms d'ingrédients(Alcool et Ingredient)
$ingredients = [];

userAccesResssource($username);

// Transforme le nom d'utilisateur en id
$id_user = usernameToId($username, $conn);

try {
    //Demande les noms d'ingrédients que l'utilisateur possède
    $requete_preparee = $conn->prepare("CALL GetMesIngredients(?)");
    $requete_preparee->bind_param("i", $id_user);
    $requete_preparee->execute();
    $resultat = $requete_preparee->get_result();
    $requete_preparee->close();

    if ($resultat->num_rows > 0) {
        while ($row = $resultat->fetch_assoc()) {
            $ingredients[] = $row['nom'];
        }

        echo json_encode($ingredients);
    } else {
        http_response_code(204);
        exit();
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode("Erreur : " . $e->getMessage());
    exit();
}

$conn->close();

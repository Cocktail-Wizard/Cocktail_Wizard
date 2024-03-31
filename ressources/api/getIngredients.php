<?php

/**
 * Script getIngredients
 *
 * Script de l'API qui permet de récupérer la liste des ingrédients de la base de données.
 * Celle ci inclut les ingrédients de type Alcool et Ingredient.
 *
 * Type de requête : GET
 *
 * URL : /api/ingredients
 *
 * @return JSON La liste des noms d'ingrédients.
 *
 * @version 1.0
 *
 * @author Yani Amellal
 */

header('Content-Type: application/json');
require_once __DIR__ . '/config.php';

// Connexion à la base de données
$conn = connexionBD();

//Liste des noms d'ingrédients(Alcool et Ingredient)
$ingredients = [];

//Demande les noms d'ingrédients
try {
    $requete_preparee = $conn->prepare("CALL GetListeIngredients()");
    $requete_preparee->execute();
    $resultat = $requete_preparee->get_result();
    $requete_preparee->close();

    if ($resultat->num_rows > 0) {
        while ($row = $resultat->fetch_assoc()) {
            $ingredients[] = $row['nom'];
        }
    } else {
        http_response_code(204);
        echo json_encode("Aucun ingrédient trouvé.");
        exit();
    }
    echo json_encode($ingredients);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode("Erreur : " . $e->getMessage());
    exit();
}

$conn->close();

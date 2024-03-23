<?php
/**
 * Script AjouterCocktail
 *
 * Script de l'API qui permet d'ajouter un nouveau cocktail à la base de données.
 *
 * Type de requête : POST
 *
 * URL : /api/cocktails
 *
 * @param JSON : nom, description, desc_cocktail, preparation, typeVerre,
 *                   profilSaveur, username, nomAlcoolPrincipale,
 *                  [ingredients] (tableau d'objets JSON {nomIng, quantite, unite}).
 *                  *nomIng peut être un nom d'ingrédient, un nom d'alcool ou un string autre.
 *
 * @return JSON Un json contenant le message de succès ou d'erreur
 *
 * @version 1.0
 *
 * @author Yani Amellal
 */
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/classephp/Cocktail_Classe.php';

$conn = connexionBD();

if ($conn == null) {
    http_response_code(500);
    echo json_encode("Erreur de connexion à la base de données.");
    exit();
}

$donnee = json_decode(file_get_contents('php://input'), true);

$userId = usernameToId($donnee['username'] , $conn);

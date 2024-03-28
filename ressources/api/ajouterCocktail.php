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
 * @param JSON : nom, description, preparation, typeVerre,
 *                   profilSaveur, username, nomAlcoolPrincipale,
 *                  [ingredients] (tableau de string JSON {nomIng, quantite, unite}).
 *                  *nomIng peut être un nom d'ingrédient, un nom d'alcool ou un string autre.
 *
 * @return JSON Un json contenant le message de succès ou d'erreur
 *
 * @version 1.0
 *
 * @author Yani Amellal
 */

header('Content-Type: application/json');
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/classephp/Cocktail_Classe.php';
require_once __DIR__ . '/fonctionAPIphp/paramJSONvalide.php';

$conn = connexionBD();

$donnee = json_decode(file_get_contents('php://input'), true);

// Vérifie si les paramètres sont présents
$nom = paramJSONvalide($donnee['nom'], 'nom du cocktail', $conn);
$description = paramJSONvalide($donnee['description'], 'description du cocktail', $conn);
$preparation = paramJSONvalide($donnee['preparation'], 'préparation du cocktail', $conn);
$typeVerre = paramJSONvalide($donnee['typeVerre'], 'type de verre du cocktail', $conn);
$profilSaveur = paramJSONvalide($donnee['profilSaveur'], 'profil de saveur du cocktail', $conn);
$nomAlcoolPrincipale = paramJSONvalide($donnee['nomAlcoolPrincipale'], 'nom de l\'alcool principale du cocktail', $conn);
$username = paramJSONvalide($donnee['username'], 'nom du créateur du cocktail', $conn);
$ingredients[] = paramJSONvalide($donnee['ingredients'], 'ingrédients du cocktail', $conn);

$userId = usernameToId(trim($donnee['username']), $conn);
try {
    $requete_preparee = $conn->prepare("CALL CreerCocktail(?, ?, ?, ?, ?, ?, ?)");
    $requete_preparee->bind_param(
        'sssssss',
        $donnee['nom'],
        $donnee['description'],
        $donnee['preparation'],
        $donnee['typeVerre'],
        $donnee['profilSaveur'],
        $userId,
        $donnee['nomAlcoolPrincipale']
    );
    $requete_preparee->execute();
    $resultat = $requete_preparee->get_result();
    $requete_preparee->close();

    if ($resultat->num_rows == 1) {
        $row = $resultat->fetch_assoc();
        $idCocktailNouveau = $row['id_cocktail'];
    } else {
        http_response_code(404);
        echo json_encode("Erreur de création du cocktail.");
        exit();
    }


    foreach ($donnee['ingredients'] as $ingredient) {
        $nomIng = $ingredient['nomIng'];
        $quantite = $ingredient['quantite'];
        $unite = $ingredient['unite'];

        $requete_preparee = $conn->prepare("CALL AjouterIngredientCocktail(?, ?, ?, ?)");
        $requete_preparee->bind_param('isss', $idCocktailNouveau, $nomIng, $quantite, $unite);
        $requete_preparee->execute();
        $requete_preparee->close();
    }

    echo json_encode("Cocktail ajouté avec succès.");
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode("Erreur : " . $e->getMessage());
    exit();
}

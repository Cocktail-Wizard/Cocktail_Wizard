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
 *                   profilSaveur, username, nomAlcoolPrincipale, image(Image en base64).
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
require_once __DIR__ . '/fonctionAPIphp/paramJSONvalide.php';
require_once __DIR__ . '/fonctionAPIphp/usernameToId.php';

$conn = connexionBD();

$donnee = json_decode(file_get_contents('php://input'), true);

// Vérifie si les paramètres sont présents
$nom = paramJSONvalide($donnee, 'nom');
$description = paramJSONvalide($donnee, 'description');
$preparation = paramJSONvalide($donnee, 'preparation');
$typeVerre = paramJSONvalide($donnee, 'typeVerre');
$profilSaveur = paramJSONvalide($donnee, 'profilSaveur');
$nomAlcoolPrincipale = paramJSONvalide($donnee, 'nomAlcoolPrincipale');
$username = paramJSONvalide($donnee, 'username');
$image = paramJSONvalide($donnee, 'image');

$userId = usernameToId($username, $conn);

// Démarre une transaction pour ajouter le cocktail afin d'éviter les incohérences dans la base de données
$conn->begin_transaction();

try {
    // Envoie une requête à l'API de gestion d'image pour ajouter l'image à la base de données
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, 'https://equipe105.tch099.ovh/images');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array('image' => $image)));

    $nomImageJSON = curl_exec($curl);
    curl_close($curl);
    // Récupère le nom de l'image
    $nomImage = json_decode($nomImageJSON, true)['NomFichier'];

    if ($nomImage == false) {
        http_response_code(500);
        echo json_encode("Erreur lors de l'ajout de l'image.");
        exit();
    }
    // Envoie une requête à la base de données pour ajouter le nom de l'image à la base de données
    $requete_preparee = $conn->prepare("CALL AjouterImageCocktail(?)");
    $requete_preparee->bind_param('s', $nomImage);
    $requete_preparee->execute();
    $resultat = $requete_preparee->get_result();
    $requete_preparee->close();
    // Récupère l'id de l'image
    if ($resultat->num_rows == 1) {
        $row = $resultat->fetch_assoc();
        $idImage = $row['id_image'];
    } else {
        http_response_code(404);
        echo json_encode("Erreur lors de l'ajout du nom de l'image à la base de donnée.");
        $conn->rollback();
        exit();
    }
    // Envoie une requête à la base de données pour ajouter le cocktail à la base de données
    $requete_preparee = $conn->prepare("CALL CreerCocktail(?, ?, ?, ?, ?, ?, ?,?)");
    $requete_preparee->bind_param(
        'sssssisi',
        $nom,
        $description,
        $preparation,
        $typeVerre,
        $profilSaveur,
        $userId,
        $nomAlcoolPrincipale,
        $idImage
    );

    $requete_preparee->execute();
    $resultat = $requete_preparee->get_result();
    $requete_preparee->close();
    // Récupère l'id du nouveau cocktail
    if ($resultat->num_rows == 1) {
        $row = $resultat->fetch_assoc();
        $idCocktailNouveau = $row['id_cocktail'];
    } else {
        http_response_code(404);
        echo json_encode("Erreur de création du cocktail.");
        $conn->rollback();
        exit();
    }
    // Envoie une requête à la base de données pour ajouter les ingrédients du cocktail à la base de données
    // Vérifie si les ingrédients sont présents
    if (!empty($donnee['ingredients'])) {

        foreach ($donnee['ingredients'] as $ingredient) {

            if (!empty($ingredient['nomIng']) && !empty($ingredient['quantite']) && isset($ingredient['unite'])) {
                $nomIng = $ingredient['nomIng'];
                $quantite = $ingredient['quantite'];
                $unite = $ingredient['unite'];
            } else {
                http_response_code(400);
                echo json_encode("Les paramètres nomIng, quantite et unite sont requis pour chaque ingrédient.");
                $conn->rollback();
                exit();
            }
            $requete_preparee = $conn->prepare("CALL AjouterIngredientCocktail(?, ?, ?, ?)");
            $requete_preparee->bind_param('isds', $idCocktailNouveau, $nomIng, $quantite, $unite);
            $requete_preparee->execute();
            $requete_preparee->close();
        }

        $conn->commit();
        echo json_encode("Cocktail ajouté avec succès.");
    } else {
        http_response_code(400);
        echo json_encode("Le cocktail doit contenir au moins un ingrédient.");
        $conn->rollback();
        exit();
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode("Erreur : " . $e->getMessage());
    $conn->rollback();
    exit();
}

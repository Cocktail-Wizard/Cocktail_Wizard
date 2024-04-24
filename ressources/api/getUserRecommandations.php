<?php

/**
 * Script getUserRecommandations
 *
 * Script de l'API qui permet de récupérer les informations qui permettent d'afficher
 * un cocktail si l'utilisateur possède les ingrédients nécessaires.
 *
 * Type de requête : GET
 *
 * URL : /api/users/$username/recommandations/tri/{like/date}  OU
 *         /api/users/$username/recommandations/type/{classiques/favoris/communaute}
 *
 * @param string $username Le nom d'utilisateur de l'utilisateur.
 *
 * @param string $type Le type de recommandation voulu.
 * OR
 * @param string $tri Le type de triage voulu.
 *
 * @return JSON Un json contenant les informations des cocktails recommandés.
 *
 * @version 1.2
 *
 * @author Yani Amellal, Vianney Veremme
 *
 * @see InfoAffichageCocktail.php
 */

header("Content-Type: application/json");
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/fonctionAPIphp/InfoAffichageCocktail.php';
require_once __DIR__ . '/fonctionAPIphp/usernameToId.php';
require_once __DIR__ . '/fonctionAPIphp/authorisationAPI.php';

$idCocktails = [];
$cocktails = [];
$ingManquants = [];

// Connexion à la base de données
$conn = connexionBD();

userAccesResssource($username);

$userID = usernameToId($username, $conn);

// Vérifie que les paramètres sont valides
$isTriInvalid = (isset($tri) && !in_array($tri, ['like', 'date']));
$isTypeInvalid = (isset($type) && !in_array($type, ['classiques', 'favoris', 'communaute']));

// Retourne une erreur si les paramètres sont invalides
if ($isTriInvalid || $isTypeInvalid) {
    http_response_code(400);
    echo json_encode("Paramètre invalide.");
    exit();
} elseif (isset($tri)) {
    // Récupère les cocktails possibles pour l'utilisateur à afficher dans la galerie
    try {
        $requete_preparee = $conn->prepare("CALL GetCocktailGalerieFiltrer(?,?,?,?,?)");
        $requete_preparee->bind_param("isiii", $userID, $tri, $page, $nbCocktailPage, $mocktail);
        $requete_preparee->execute();
        $resultat = $requete_preparee->get_result();
        $requete_preparee->close();
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode("Erreur : " . $e->getMessage());
        exit();
    }
} elseif (isset($type)) {
    try {
        switch ($type) {
                // Récupère les cocktails possibles pour l'utilisateur à afficher dans la section Classiques
            case 'classiques':
                $requete_preparee = $conn->prepare("CALL GetCocktailsPossibleClassique(?,?,?,?)");
                $requete_preparee->bind_param("iiii", $userID, $page, $nbCocktailPage, $mocktail);
                $requete_preparee->execute();
                $resultat = $requete_preparee->get_result();
                $requete_preparee->close();
                break;
                // Récupère les cocktails possibles pour l'utilisateur à afficher dans la section Favoris
            case 'favoris':
                $requete_preparee = $conn->prepare("CALL GetListeCocktailPossibleFavorie(?,?,?,?)");
                $requete_preparee->bind_param("iiii", $userID, $page, $nbCocktailPage, $mocktail);
                $requete_preparee->execute();
                $resultat = $requete_preparee->get_result();
                $requete_preparee->close();
                break;
                // Récupère les cocktails possibles pour l'utilisateur à afficher dans la section Communauté
            case 'communaute':
                $requete_preparee = $conn->prepare("CALL GetCocktailsPossibleCommunautaire(?,?,?,?)");
                $requete_preparee->bind_param("iiii", $userID, $page, $nbCocktailPage, $mocktail);
                $requete_preparee->execute();
                $resultat = $requete_preparee->get_result();
                $requete_preparee->close();
                break;
            default:
                http_response_code(400);
                echo json_encode("Paramètre de type invalide.");
                exit();
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode("Erreur : " . $e->getMessage());
        exit();
    }
}

if ($resultat->num_rows > 0) {
    //Ajoute les id des cocktails à la liste
    while ($row = $resultat->fetch_assoc()) {
        $idCocktails[] = $row['id_cocktail'];
        $ingManquants[$row['id_cocktail']] = $row['ing_manquant'];
    }
} else {
    http_response_code(204);
    exit();
}

foreach ($idCocktails as $id) {
    $cocktails[] = InfoAffichageCocktail($id, $conn);
}

// Ajoute le nombre d'ingrédients manquants à chaque cocktail
foreach ($cocktails as $cocktail) {
    $cocktail->setIngManquant($ingManquants[$cocktail->getIdCocktail()]);
}

echo json_encode($cocktails);

$conn->close();

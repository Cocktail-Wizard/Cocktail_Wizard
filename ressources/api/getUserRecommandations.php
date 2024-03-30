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

$idCocktails = [];
$cocktails = [];

// Connexion à la base de données
$conn = connexionBD();

$userID = usernameToId($username, $conn);

// Vérifie que les paramètres sont valides
$isTriInvalid = (isset($tri) && !in_array($tri, ['like', 'date']));
$isTypeInvalid = (isset($type) && !in_array($type, ['classiques', 'favoris', 'communaute']));

if ($isTriInvalid || $isTypeInvalid) {
    http_response_code(400);
    echo json_encode("Paramètre invalide.");
    exit();
} elseif (isset($tri)) {
    try {
        $requete_preparee = $conn->prepare("CALL GetCocktailGalerieFiltrer(?,?)");
        $requete_preparee->bind_param("is", $userID, $tri);
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
            case 'classiques':
                $requete_preparee = $conn->prepare("CALL GetCocktailPossibleClassique(?)");
                $requete_preparee->bind_param("i", $userID);
                $requete_preparee->execute();
                $resultat = $requete_preparee->get_result();
                $requete_preparee->close();
                break;
            case 'favoris':
                $requete_preparee = $conn->prepare("CALL getCocktailFavorieMonBar(?)");
                $requete_preparee->bind_param("i", $userID);
                $requete_preparee->execute();
                $resultat = $requete_preparee->get_result();
                $requete_preparee->close();
                break;
            case 'communaute':
                $requete_preparee = $conn->prepare("CALL getCocktailCommunataireMonBar(?)");
                $requete_preparee->bind_param("i", $userID);
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
    }
} else {
    http_response_code(404);
    echo json_encode("Aucun cocktail trouvé.");
    exit();
}

foreach ($idCocktails as $id) {
    $cocktails[] = InfoAffichageCocktail($id, $conn);
}

echo json_encode($cocktails);

$conn->close();

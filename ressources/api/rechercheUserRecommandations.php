<?php

/**
 * Script rechercheCocktail
 *
 * Script de l'API qui permet de rechercher des cocktails en fonction de mots-clés
 * et de les trier selon un critère donné.
 *
 * Type de requête : GET
 *
 * URL : /api/cocktails/tri/{like/date}/recherche/{mot-clé, mot-clé, mot-clé}
 *
 * @param string $tri Le type de triage voulu.
 *
 * @param string $mots Les mots-clés de recherche.
 *
 * @return JSON Un json contenant les informations des cocktails trouvés.
 *
 * @version 1.0
 *
 * @author Yani Amellal
 *
 * @see InfoAffichageCocktail.php
 */

header('Content-Type: application/json');
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/fonctionAPIphp/usernameToId.php';
require_once __DIR__ . '/fonctionAPIphp/InfoAffichageCocktail.php';
require_once __DIR__ . '/fonctionAPIphp/authorisationAPI.php';

$conn = connexionBD();

$cocktails = []; //Liste d'objets Cocktail
$idCocktails = []; //Liste d'id de cocktails
$ingManquants = []; //Liste d'ingrédients manquants

userAccesResssource($username);
$userId = usernameToId($username, $conn);

try {
    $requete_preparee = $conn->prepare("CALL RechercheCocktailFiltrer(?,?,?,?,?,?)");
    $requete_preparee->bind_param('sisiii', $recherche, $userId, $tri, $page, $nbCocktailPage, $mocktail);
    $requete_preparee->execute();
    $resultat = $requete_preparee->get_result();

    $requete_preparee->close();

    if ($resultat->num_rows > 0) {
        while ($row = $resultat->fetch_assoc()) {
            $id_cocktail[] = $row['id_cocktail'];
            $ingManquants[$row['id_cocktail']] = $row['ing_manquant'];
        }
    } else {
        http_response_code(204);
        exit();
    }

    foreach ($id_cocktail as $id) {
        $cocktails[] = InfoAffichageCocktail($id, $conn);
    }

    foreach ($cocktails as $cocktail) {
        $cocktail->setIngManquant($ingManquants[$cocktail->getIdCocktail()]);
    }

    echo json_encode($cocktails);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode("Erreur : " . $e->getMessage());
    exit();
}

$conn->close();

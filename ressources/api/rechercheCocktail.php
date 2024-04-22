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

$conn = connexionBD();

$cocktails = [];
$id_cocktail = [];


try {
    $requete_preparee = $conn->prepare("CALL RechercheCocktail(?,?,?,?)");
    $requete_preparee->bind_param('ssii', $recherche, $tri, $page, $nbCocktailPage);
    $requete_preparee->execute();
    $resultat = $requete_preparee->get_result();

    $requete_preparee->close();

    if ($resultat->num_rows > 0) {
        while ($row = $resultat->fetch_assoc()) {
            $id_cocktail[] = $row['id_cocktail'];
        }
    } else {
        http_response_code(204);
        exit();
    }

    foreach ($id_cocktail as $id) {
        $cocktails[] = InfoAffichageCocktail($id, $conn);
    }

    echo json_encode($cocktails);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode("Erreur : " . $e->getMessage());
    exit();
}

$conn->close();

<?php

/**
 * Script getCocktailCommentaires
 *
 * Script de l'API qui permet de récupérer les commentaires d'un cocktail.
 *
 * Type de requête : GET
 *
 * URL : /api/cocktails/$id_cocktail/commentaires
 *
 * @param int $id_cocktail L'id du cocktail dont on veut les commentaires.
 *
 * @return JSON Un json contenant la liste des commentaires du cocktail.
 *
 * @version 1.1
 *
 * @author Yani Amellal
 */

header("Content-Type: application/json");
require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/../classephp/Commentaire_Classe.php');

$conn = connexionBD();

$id_cocktail_s = mysqli_real_escape_string($conn, $id_cocktail);
$id_cocktails_s = intval($id_cocktail_s);

try {
    $requete_preparee = $conn->prepare("CALL GetCommentairesCocktail(?, 'like')");
    $requete_preparee->bind_param("i", $id_cocktail_s);
    $requete_preparee->execute();
    $resultat = $requete_preparee->get_result();
    $requete_preparee->close();

    if ($resultat->num_rows > 0) {
        // Liste d'objets commentaires du cocktail
        $commentaires = [];
        while ($row = $resultat->fetch_assoc()) {
            $commentaire = new Commentaire(
                $row['id_commentaire'],
                $row['img'],
                $row['nom'],
                $row['date_commentaire'],
                $row['contenu'],
                $row['nb_like']
            );
            $commentaires[] = $commentaire;
        }
    } else {
        http_response_code(204);
        echo json_encode("Aucun commentaire trouvé.");
        exit();
    }

    echo json_encode($commentaires);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode("Erreur : " . $e->getMessage());
    exit();
}

$conn->close();

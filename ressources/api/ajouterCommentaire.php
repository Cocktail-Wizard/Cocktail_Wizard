<?php

/**
 * Script ajouterCommentaire
 *
 * Script de l'API qui permet d'ajouter un commentaire à un cocktail.
 *
 * Type de requête : POST
 *
 * URL : /api/cocktails/commentaires
 *
 * @param JSON : username, id_cocktail, commentaire
 *
 * @return JSON Un json contenant la nouvelle liste des commentaires du cocktail.
 *
 * @version 1.0
 *
 * @author Yani Amellal
 */

header('Content-Type: application/json');
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/fonctionAPIphp/usernameToId.php';
require_once __DIR__ . '/../classephp/Commentaire_Classe.php';
require_once __DIR__ . '/fonctionAPIphp/paramJSONvalide.php';

$conn = connexionBD();

$donnees = json_decode(file_get_contents('php://input'), true);

// Vérifie si les paramètres sont présents et les échappe
$username = paramJSONvalide($donnees, 'username');
$idCocktail = paramJSONvalide($donnees, 'id_cocktail');
$contenuCommentaire = paramJSONvalide($donnees, 'commentaire');

$userId = usernameToId($username, $conn);

try {
    $requete_preparee = $conn->prepare("CALL AjouterCommentaireCocktail(?, ?, ?)");
    $requete_preparee->bind_param('iis', $idCocktail, $userId, $contenuCommentaire);
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

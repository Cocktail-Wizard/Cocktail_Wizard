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
require_once __DIR__ . '/fonctionAPIphp/authorisationAPI.php';

$conn = connexionBD();

$donnees = json_decode(file_get_contents('php://input'), true);

// Vérifie si les paramètres sont présents et les échappe
$username = paramJSONvalide($donnees, 'username');
$idCocktail = paramJSONvalide($donnees, 'id_cocktail');
$contenuCommentaire = paramJSONvalide($donnees, 'commentaire');

userAccesResssource($username);
$userId = usernameToId($username, $conn);

try {
    // Envoie une requête à la base de données pour ajouter le commentaire
    $requete_preparee = $conn->prepare("CALL AjouterCommentaireCocktail(?, ?, ?)");
    $requete_preparee->bind_param('iis', $idCocktail, $userId, $contenuCommentaire);
    $requete_preparee->execute();
    $resultat = $requete_preparee->get_result();
    $requete_preparee->close();

    // Liste d'objets commentaires du cocktail
    $commentaires = [];
    // Retourne la liste des commentaires du cocktail
    if ($resultat->num_rows > 0) {

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
    }

    echo json_encode($commentaires);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode("Erreur : " . $e->getMessage());
    exit();
}

$conn->close();

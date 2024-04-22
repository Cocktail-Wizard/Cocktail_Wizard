<?php

/**
 * Script modifierMotdePasse
 *
 * Script de l'API qui permet de modifier le mot de passe d'un utilisateur.
 *
 * Type de requête : POST
 *
 * URL : /api/users/modifierMotDePasse
 *
 * @param JSON : mdp, nouveauMdp, confNouveauMdp
 *
 * @return JSON Un json contenant le message de succès ou d'erreur
 *
 * @version 1.0
 *
 * @author Pablo Hamel-Corôa
 */

header('Content-Type: application/json');
require_once(__DIR__ . "/config.php");
require_once(__DIR__ . "/fonctionAPIphp/paramJSONvalide.php");
require_once(__DIR__ . "/fonctionAPIphp/usernameToId.php");


$donnee = json_decode(file_get_contents('php://input'), true);
// Accumulateur d'erreurs
$erreurs = array();
$success = false;
$mdp = paramJSONvalide($donnee, 'mdp');
$nouveauMdp = paramJSONvalide($donnee, 'nouveauMdp');
$confNouveauMdp = paramJSONvalide($donnee, "confNouveauMdp");
$nom = paramJSONvalide($donnee, 'nom');


// Valider le nouveau mot de passe
if (strlen($nouveauMdp) < 8) {
    $erreurs[] = "Le nouveau mot de passe doit contenir au moins 8 caractères!";
} else if ($nouveauMdp != $confNouveauMdp) {
    $erreurs[] = "Les mots de passe ne correspondent pas!";
}

// Si aucune erreur, connexion à la base de données
if (empty($erreurs)) {
    $nouveauMdp_hashed = password_hash($nouveauMdp, PASSWORD_DEFAULT);

    $conn = connexionBD();

    // Vérifier le mot de passe actuel avec celui de la base de données
    try {
        $requete_preparee = $conn->prepare("CALL  ConnexionUtilisateur(?)");
        $requete_preparee->bind_param("s", $nom);
        $requete_preparee->execute();
        $resultat = $requete_preparee->get_result();
        $requete_preparee->close();

        if ($resultat->num_rows > 0) {
            $utilisateur = $resultat->fetch_assoc();
            $mdp_hashed = $utilisateur['mdp_hashed'];
            $userId = usernameToId($nom, $conn);
            // Vérifier le mot de passe
            if (password_verify($mdp, $mdp_hashed)) {
                try {
                    $requete_preparee = $conn->prepare("CALL  ModifierMotDePasse(?,?)");
                    $requete_preparee->bind_param("is", $userId, $nouveauMdp_hashed);
                    $requete_preparee->execute();

                    if ($conn->affected_rows > 0) {
                        echo json_encode(['success' => true, 'message' => 'Votre mot de passe a été modifié avec succès!']);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Erreur lors de la modification du mot de passe!']);
                    }
                    $requete_preparee->close();
                } catch (Exception $e) {
                    http_response_code(500);
                    echo json_encode("Erreur : " . $e->getMessage());
                    exit();
                }
            } else {
                $erreurs[] = "Mot de passe incorrect!";
            }
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode("Erreur : " . $e->getMessage());
        exit();
    }
}
echo json_encode(['success' => false, 'erreurs' => $erreurs]);

$conn->close();

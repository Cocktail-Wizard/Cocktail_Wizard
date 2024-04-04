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
 * @param FormData : mdp, nouveauMdp, confNouveauMdp
 *
 * @return JSON Un json contenant le message de succès ou d'erreur
 *
 * @version 1.0
 *
 * @author Pablo Hamel-Corôa
 */

header('Content-Type: application/json');
require_once(__DIR__ . "/config.php");

// Accumulateur d'erreurs
$erreurs = array();
$success = false;

// Valider le mot de passe
if (empty($_POST['mdp'])) {
    $erreurs[] = "Le mot de passe est requis!";
}

// Valider le nouveau mot de passe
if (empty($_POST['nouveauMdp']) || strlen($_POST['nouveauMdp']) < 8) {
    $erreurs[] = "Le nouveau mot de passe doit contenir au moins 8 caractères!";
} else if ($_POST['nouveauMdp'] != $_POST['confNouveauMdp']) {
    $erreurs[] = "Les mots de passe ne correspondent pas!";
}

// Si aucune erreur, connexion à la base de données
if (empty($erreurs)) {
    $mdp = trim($_POST['mdp']);
    $nouveauMdp = trim($_POST['nouveauMdp']);
    $nouveauMdp_hashed = password_hash($nouveauMdp, PASSWORD_DEFAULT);
    $nom = $_SESSION['nom'];

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

            // Vérifier le mot de passe
            if (password_verify($mdp, $mdp_hashed)) {
                try {
                    $requete_preparee = $conn->prepare("CALL  ModifierMotDePasse(?,?)");
                    $requete_preparee->bind_param("ss", $nom, $nouveMdp_hashed);
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

$conn->close();

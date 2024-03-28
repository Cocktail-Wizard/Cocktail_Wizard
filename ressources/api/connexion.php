<?php

/**
 * Script connexion
 *
 * Script de l'API qui permet de connecter un utilisateur à la base de données.
 *
 * Type de requête : POST
 *
 * URL : /api/users/authentification
 *
 * @param FormData : nom, mdp
 *
 * @return JSON Un json contenant le message de succès ou d'erreur
 *
 * @version 1.2
 *
 * @author Pablo Hamel-Corôa, Vianney Veremme, Yani Amellal
 */

header('Content-Type: application/json');
require_once("config.php");
// Accumulateur d'erreurs
$erreurs = array();
$success = false;

// Valider le nom d'utilisateur
if (empty($_POST['nom'])) {
    $erreurs[] = "Le nom d'utilisateur est requis!";
}

// Valider le mot de passe
if (empty($_POST['mdp'])) {
    $erreurs[] = "Le mot de passe est requis!";
}

// Si aucune erreur, établir la connexion
if (empty($erreurs)) {
    $conn = connexionBD();

    $nom = mysqli_real_escape_string($conn, trim($_POST['nom']));
    $mdp = mysqli_real_escape_string($conn, trim($_POST['mdp']));

    try {
        // Rechercher le mot de passe dans la base de données
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
                $success = true;
            } else {
                // Mot de passe incorrect
                $erreurs[] = "Mot de passe incorrect!";
            }
        } else {
            // Nom d'utilisateur non trouvé
            $erreurs[] = "Nom d'utilisateur introuvable!";
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode("Erreur : " . $e->getMessage());
        exit();
    }
}

// Construction de la réponse JSON
$response = array(
    "success" => $success,
    "errors" => $erreurs
);

if ($success) {
    $response["username"] = $nom;
}

if (!empty($erreurs)) {
    http_response_code(400);
}
// Répondre avec la réponse JSON
echo json_encode($response);

$conn->close();

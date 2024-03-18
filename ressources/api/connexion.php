<?php
require("config.php");
session_start();
// Accumulateur d'erreurs
$erreurs = array();
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
        $nom = mysqli_real_escape_string($conn, trim($_POST['nom']));
        $mdp = mysqli_real_escape_string($conn, trim($_POST['mdp']));

        // Rechercher le mot de passe dans la base de données
        $requete_preparee = $conn->prepare("SELECT mdp_hashed FROM utilisateur WHERE nom = ?");
        $requete_preparee->bind_param("s", $nom);
        $requete_preparee->execute();
        $resultat = $requete_preparee->get_result();

        if ($resultat->num_rows > 0) {
            $utilisateur = $resultat->fetch_assoc();
            $mdp_hashed = $utilisateur['mdp_hashed'];

            // Vérifier le mot de passe
            if (password_verify($mdp, $mdp_hashed)) {
                // Authentification réussie
                $_SESSION['nom'] = $nom;
                $success = true;
            } else {
                // Mot de passe incorrect
                $erreurs[] = "Mot de passe incorrect!";
            }
        } else {
            // Nom d'utilisateur non trouvé
            $erreurs[] = "Nom d'utilisateur introuvable!";
        }

        $requete_preparee->close();
    }
}

// Construction de la réponse JSON
$response = array(
    "success" => $success,
    "errors" => $erreurs
);

// Répondre avec la réponse JSON
echo json_encode($response);

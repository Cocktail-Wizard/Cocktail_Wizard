<?php
require("config.php");
session_start();
// Accumulateur d'erreurs
$erreurs = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Valider le nom d'utilisateur
    if (empty($_POST['nom'])) {
        $erreurs[] = "Le nom d'utilisateur entré est invalide!<br>";
    }

    // Valider le mot de passe
    if (empty($_POST['mdp'])) {
        $erreurs[] = "Le mot de passe entré est invalide!<br>";
    }

    // Si aucune erreur, établir la connexion
    if (count($erreurs) == 0) {
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
                header("Location: ../../index.html");
                exit();
            } else {
                // Mot de passe incorrect
                $erreurs[] = "Mot de passe incorrect!<br>";
            }
        } else {
            // Nom d'utilisateur non trouvé
            $erreurs[] = "Nom d'utilisateur non trouvé!<br>";
        }

        $requete_preparee->close();
    }
}

// Répondre avec les erreurs au format JSON
echo json_encode($erreurs);

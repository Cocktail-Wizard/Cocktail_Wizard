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


        //  Rechercher le mot de passe dans la base de données
        $requete_preparee = $conn->prepare("SELECT * FROM `utilisateur` WHERE nom = ?");

        //  Lier le mot de passe (String) à l'identifiant
        $requete_preparee->execute([$nom]);
        $resultat = $requete_preparee->get_result();
        $util = $resultat->fetch_assoc();

        if ($resultat->num_rows > 0) {
            $mdp_encrypter = $util['mdp'];
        }

        $requete_preparee->close();

        if ($resultat->num_rows > 0 && password_verify($mdp, $mdp_encrypter)) {
            $_SESSION['nom'] = $nom;
            //  Rediriger l'utilisateur vers la page de galerie
            echo "Connexion reussie!";
            header("Location: galerie.php");
            exit();
        } else {
            echo "Echec de connexion.";
        }
    }
}

// Répondre avec les erreurs au format JSON
echo json_encode($erreurs);

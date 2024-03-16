<?php
require ("bdd.php");
session_start();
// Accumulateur d'erreurs
$erreurs = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Valider le nom d'utilisateur
    if (empty ($_POST['nom'])) {
        $erreurs[] = "Le nom d'utilisateur entré est invalide!<br>";
    }

    // Valider le mot de passe
    if (empty ($_POST['mdp'])) {
        $erreurs[] = "Le mot de passe entré est invalide!<br>";
    }

    // Si aucune erreur, établir la connexion
    if (count($erreurs) == 0) {
        //  Établir la connexion avec la base de données
        $conn = connexion("cocktailwizbd.mysql.database.azure.com", "cocktail", "Cw-yplmv");
        $nom = mysqli_real_escape_string($conn, trim($_POST['nom']));
        $mdp = mysqli_real_escape_string($conn, trim($_POST['mdp']));
        if ($conn == null)
            die ("Erreur");

        //  Rechercher le mot de passe dans la base de données
        $requete_preparee = $conn->prepare("SELECT mdp FROM utilisateur WHERE nom = ?");
        //  Lier le mot de passe (String) à l'identifiant
        $requete_preparee->bind_param("s", $nom);
        $requete_preparee->execute();
        $resultat = $requete_preparee->get_result();
        $util = $resultat->fetch_assoc();
        if ($resultat->num_rows > 0) {
            $mdp_encrypter = $util['mdp'];
        }
        $requete_preparee->close();

        if ($resultat->num_rows > 0 && password_verify($mdp, $mdp_encrypter)) {
            $_SESSION['nom'] = $nom;
            //  Rediriger l'utilisateur vers la page de galerie
            header("Location: galerie.php");
            exit();
        }
    }
}

// Répondre avec les erreurs au format JSON
echo json_encode($erreurs);

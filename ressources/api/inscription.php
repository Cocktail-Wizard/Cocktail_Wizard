<?php
require("config.php");
session_start();
// Accumulateur d'erreurs
$erreurs = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Valider le nom d'utilisateur
    if (empty($_POST['nom'])) {
        $erreurs[] = "Le nom d'utilisateur est invalide!<br>";
    }

    // Valider le courriel
    if (empty($_POST['courriel']) || !filter_var($_POST['courriel'], FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "Le courriel est invalide!<br>";
    }

    // Vérifier si le courriel est déjà utilisé
    $courriel = mysqli_real_escape_string($conn, trim($_POST['courriel']));
    $requete_preparee = $conn->prepare("SELECT * FROM utilisateur WHERE courriel = ?");
    $requete_preparee->bind_param("s", $courriel);
    $requete_preparee->execute();
    $resultat = $requete_preparee->get_result();
    $requete_preparee->close();
    if ($resultat->num_rows > 0) {
        $erreurs[] = "Le courriel est déjà utilisé!";
    }

    // Valider le mot de passe et les autres champs
    if (empty($_POST['mdp']) || strlen($_POST['mdp']) < 8) {
        $erreurs[] = "Le mot de passe doit contenir au moins 8 caractères!<br>";
    }
    if ($_POST['mdp'] != $_POST['confmdp']) {
        $erreurs[] = "Les mots de passe ne correspondent pas!<br>";
    }
    if (empty($_POST['naissance'])) {
        $erreurs[] = "La date de naissance est invalide!<br>";
    }

    // Si le formulaire est valide, insérer les données dans la base de données
    if (count($erreurs) == 0) {
        $nom = mysqli_real_escape_string($conn, trim($_POST['nom']));
        $mdp = mysqli_real_escape_string($conn, trim($_POST['mdp']));
        $mdp_encrypte = password_hash($mdp, PASSWORD_DEFAULT);
        $date_nais = date('Y-m-d', strtotime(trim($_POST['naissance'])));

        $requete_preparee = $conn->prepare("INSERT INTO utilisateur (nom, courriel, mdp_hashed, date_naiss) VALUES (?, ?, ?, ?)");
        $requete_preparee->bind_param("ssss", $nom, $courriel, $mdp_encrypte, $date_nais);
        if ($requete_preparee->execute()) {
            // Rediriger vers la page de connexion si l'inscription est réussie
            header("Location: ../../pages/connexion.html");
            exit();
        } else {
            $erreurs[] = "Erreur lors de l'inscription!";
        }
    }
}

// Répondre avec les erreurs au format JSON
echo json_encode($erreurs);

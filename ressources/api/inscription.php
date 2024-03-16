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
    if (empty($_POST['courriel']) || !str_contains($_POST["courriel"], "@") || !str_contains($_POST["courriel"], ".")) {
        $erreurs[] = "Le courriel est invalide!<br>";
    }

    // Verifier si le courriel est deja utilise
    if ($conn->connect_error) {
        die("Erreur de connexion à la base de données: " . $conn->connect_error);
    }

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

    // Si le formulaire est valide, insérer les données dans la base de données
    if (count($erreurs) == 0) {
        // Insérer les données dans la base de données
        // ...

        // Rediriger vers la page de connexion si l'inscription est réussie
        header("Location: connexion.php");
        exit();
    }
}

// Répondre avec les erreurs au format JSON
echo json_encode($erreurs);

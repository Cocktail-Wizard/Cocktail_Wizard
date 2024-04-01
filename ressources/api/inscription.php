<?php
header('Content-Type: application/json');
require("config.php");

$conn = connexionBD();

// Accumulateur d'erreurs
$erreurs = array();


// Valider le nom d'utilisateur
if (empty($_POST['nom'])) {
    $erreurs[] = "Le nom d'utilisateur est invalide!";
}

// Valider le courriel
if (empty($_POST['courriel']) || !filter_var($_POST['courriel'], FILTER_VALIDATE_EMAIL)) {
    $erreurs[] = "Le courriel est invalide!";
}

// Valider le mot de passe et les autres champs
if (empty($_POST['mdp']) || strlen($_POST['mdp']) < 8) {
    $erreurs[] = "Le mot de passe doit contenir au moins 8 caractères!";
} else if ($_POST['mdp'] != $_POST['confmdp']) {
    $erreurs[] = "Les mots de passe ne correspondent pas!";
}

if (empty($_POST['naissance'])) {
    $erreurs[] = "La date de naissance est invalide!";
}

// Si le formulaire est valide, insérer les données dans la base de données
if (count($erreurs) == 0) {
    $nom = trim($_POST['nom']);
    $mdp = trim($_POST['mdp']);
    $mdp_encrypte = password_hash($mdp, PASSWORD_DEFAULT);
    $date_nais = date('Y-m-d', strtotime(trim($_POST['naissance'])));
    $courriel = filter_var($_POST['courriel'], FILTER_SANITIZE_EMAIL);

    try {
        $requete_preparee = $conn->prepare("CALL InscriptionUtilisateur(?,?,?,?)");
        $requete_preparee->bind_param('ssss', $nom, $courriel, $mdp_encrypte, $date_nais);
        $requete_preparee->execute();
        $resultat = $requete_preparee->get_result();
    } catch (Exception $e) {
        $messErreur = $e->getMessage();

        if (strpos($messErreur, 'nom') !== false) {
            $erreurs[] = "Le nom d'utilisateur est déjà utilisé!";
        } else if (strpos($messErreur, 'courriel') !== false) {
            $erreurs[] = "Le courriel est déjà utilisé!";
        } else {
            $erreurs[] = "Erreur inconnue!";
        }
    } finally {
        $requete_preparee->close();
    }
}

if (count($erreurs) == 0) {
    echo json_encode("Inscription réussie!");
} else {
    http_response_code(400);
    echo json_encode($erreurs);
}

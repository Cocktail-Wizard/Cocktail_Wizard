<?php
require("../ressources/api/connexion.php");
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

    // Si aucune erreur, etablir la connexion
    if (count($erreurs) == 0) {
        //  Etablir la connexion avec la base de donnée
        $conn = connexion("cocktailwizbd.mysql.database.azure.com", "cocktail", "Cw-yplmv");
        $nom = mysqli_real_escape_string($conn, trim($_POST['nom']));
        $mdp = mysqli_real_escape_string($conn, trim($_POST['mdp']));
        if ($conn == null)
            die("Erreur");

        //  Rechercher le mot de passe dans la base de donnée
        $requete_preparee = $conn->prepare("SELECT mdp FROM utilisateur WHERE nom = ?");
        //  Lié le mot de passe (String) à l'identifiant
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
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="../ressources/styles/main.css">
    <link rel="stylesheet" href="../ressources/styles/connexion.css">
</head>

<body>
    <div id="connexion">
        <!-- Mettre le chemin appropriee une fois que l'organisation des fichiers soient etabli -->
        <img src="../ressources/images/sparkles.png" id="logoCW" alt="Logo Cocktail Wizard">
        <form id="form-connexion" method="post">
            <h1>Cocktail Wizard</h1>

            <label for="nom">Nom d'utilisateur</label>
            <input type="text" name="nom" placeholder="Entrer votre nom d'utilisateur" required>

            <label for="mdp">Mot de Passe</label>
            <input type="password" name="mdp" placeholder="Entrer votre mot de passe" required>

            <button type="submit">Connexion</button>

            <p>Vous n'êtes pas encore membre?</p>
            <a href="../pages/inscription.php">Créer un compte</a>
            <?php if (!empty($erreurs)) : ?>
                <?php foreach ($erreurs as $erreur) : ?>
                    <p class="erreur"><?= $erreur ?></p><br>
                <?php endforeach; ?>
            <?php endif; ?>
        </form>
    </div>

    <footer>Cocktail Wizard &copy - 2024</footer>
</body>

</html>

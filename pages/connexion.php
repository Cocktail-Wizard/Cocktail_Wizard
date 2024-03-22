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
    <section id="message-erreur" class="erreur">
        <!-- Les erreurs seront affichées ici -->
    </section>

    <main>
        <!-- Mettre le chemin approprié une fois que l'organisation des fichiers soit établie -->
        <img src="../ressources/images/sparkles.png" id="logoCW" alt="Logo Cocktail Wizard">
        <form id="form-connexion" method="post">
            <h1>Cocktail Wizard</h1>

            <label for="nom">Nom d'utilisateur</label>
            <input type="text" name="nom" placeholder="Entrer votre nom d'utilisateur" required>

            <label for="mdp">Mot de Passe</label>
            <input type="password" name="mdp" placeholder="Entrer votre mot de passe" required>

            <button type="submit">Connexion</button>

            <p>Vous n'êtes pas encore membre?</p>
            <a href="https://cocktailwizard.azurewebsites.net/inscription">Créer un compte</a>
        </form>
    </main>

    <footer>Cocktail Wizard &copy - 2024</footer>

    <script src="../ressources/scripts/connexion.js"></script>
</body>

</html>

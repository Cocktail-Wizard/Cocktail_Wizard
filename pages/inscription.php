<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="../ressources/styles/main.css">
    <link rel="stylesheet" href="../ressources/styles/inscription.css">
</head>

<body>
    <section id="message-erreur">
        <!-- Messages d'erreur affichés dynamiquement par JavaScript -->
    </section>

    <main>
        <img src="../ressources/images/sparkles.png" id="logoCW" alt="Logo Cocktail Wizard">
        <form id="form-inscription" method="post">
            <h1>Devenir membre</h1>

            <label for="nom">Nom d'utilisateur</label>
            <input type="text" name="nom" placeholder="Entrer votre nom d'utilisateur" required>

            <label for="courriel">Courriel</label>
            <input type="email" name="courriel" placeholder="exemple@cocktailwizard.com" required>

            <label for="mdp">Mot de Passe</label>
            <input type="password" name="mdp" placeholder="Entrer votre mot de passe" required>

            <label for="confmdp">Confirmation Mot de Passe</label>
            <input type="password" name="confmdp" placeholder="Confirmer votre mot de passe" required>

            <label for="naissance">Date de naissance</label>
            <input type="date" name="naissance" required>

            <button type="submit">S'inscrire</button>
        </form>

    </main>

    <footer>Cocktail Wizard &copy - 2024</footer>

    <script src="../ressources/scripts/inscription.js"></script>
</body>

</html>

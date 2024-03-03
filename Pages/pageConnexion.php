<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>

<div id="connexion">
    <img src="../images/logoCW.png" id="logoCW" alt="Logo Cocktail Wizard">
    <form id="form-connexion" action="post">
        <h1>COCKTAIL WIZARD</h1>
        <label for="nom">Nom d'utilisateur</label>
        <input type="text" name="nom" placeholder="Entrer votre nom d'utilisateur" required>
        <label for="mdp">Mot de Passe</label>
        <input type="password" name="mdp" placeholder="Entrer votre mot de passe" required>
        <label for="naissance">Date de naissance</label>
        <input type="date" name="naissance" required>
        <button type="submit">Connexion</button>

        <p>Vous n'êtes pas encore membre?</p>
        <a href="inscription.php">Créer un compte</a>
    </form>
</div>
</body>
</html>

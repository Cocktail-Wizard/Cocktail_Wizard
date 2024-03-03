<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>

    <!-- Mettre dans les fichiers CSS appropriee -->
    <style>
        html{
            background-color: #232946;
        }
        #connexion{
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
        }
        #logoCW{
            border-radius: 50px 0px 0px 50px;
            width: 36.25rem;
            height: 36.25rem;
            margin-top: 5%;
        }
        #form-connexion{
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-top: 5%;
            background-color: #B8C1EC;
            border-radius: 0px 50px 50px 0px;
            width: 31.25rem;
            height: 36.25rem;
        }
        #form-connexion > h1{
        font-family: 'merriweather', 'serif';
        }
        #form-connexion > input{
            margin-top: 0.625rem;
            margin-bottom: 0.625rem;
            padding: 0.625rem;
            border: none;
            border-radius: 1.875rem;
            width: 18.75rem;
        }
        #form-connexion > button{
            margin-top: 0.625rem;
            padding: 0.9375rem;
            font-size: 1.25rem;
            background-color: #EEBBC3;
            color: black;
            border: none;
            border-radius: 1.875rem;
            width: 13.75rem;
            }
    </style>
</head>
<body>

<div id="connexion">
<!-- Mettre le chemin appropriee une fois que l'organisation des fichiers soient etabli -->
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

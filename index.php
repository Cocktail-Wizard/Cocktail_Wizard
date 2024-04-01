<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="ressources/styles/main.css">
    <link rel="stylesheet" href="ressources/styles/index.css">
    <link rel="stylesheet" href="ressources/styles/modale.css">
    <link rel="stylesheet" href="ressources/styles/carte_cocktail.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="ressources/scripts/outils.js"></script>
    <title>Cocktail Wizard</title>
</head>

<body>
    <noscript class="erreur">Vous devez activer JavaScript pour charger ce site web.</noscript>

    <header>
        <h1>Cocktail Wizard</h1>
    </header>

    <main>
        <nav><input id="barre-recherche" type="text" placeholder="Recherchez un cocktail..." autocomplete="off" autofocus></nav>
        
        <section id="galerie"></section>
    </main>

    <aside id="contenant-modale"></aside>

    <aside id="contenant-boutons-fixes">
        <a href="/connexion" title="Connexion">
            <img src="ressources/images/icone-profile.svg" alt="Icone profile">
        </a>
    </aside>

    <footer>Cocktail Wizard &copy - 2024</footer>

    <script src="ressources/scripts/index.js"></script>
    <script src="ressources/scripts/modale.js"></script>
</body>

</html>

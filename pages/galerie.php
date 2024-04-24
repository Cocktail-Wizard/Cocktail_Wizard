<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cocktail Wizard</title>
    <link rel="stylesheet" href="ressources/styles/main.css">
    <link rel="stylesheet" href="ressources/styles/index.css">
    <link rel="stylesheet" href="ressources/styles/modale.css">
    <link rel="stylesheet" href="ressources/styles/carte_cocktail.css">
</head>

<body>
    <noscript class="erreur">Vous devez activer JavaScript pour charger ce site web.</noscript>

    <header id="top">
        <h1 class="neonText-pink">COCKTAIL WIZARD</h1>
        <div class="button-container">
            <a id="bouton-connexion" class="connexion-pic" href="/connexion" title="Connexion">
                <img src="ressources/images/icone-profile.svg" alt="Icone profile">
            </a>
        </div>
    </header>

    <main>
        <nav>
            <div class="nav-top">
                <input id="barre-recherche" type="text" placeholder="Recherchez un cocktail..." autocomplete="off" autofocus>
                <button id="ordre-tri" title="Ordonner par mentions j'aime">
                    <img id="ordre-tri-icone" src="ressources/images/icone-calendrier.svg" alt="Ordre">
                    <img src="ressources/images/tete-fleche-bas.svg" alt="Ordre décroissant">
                </button>
            </div>
            <div class="nav-radio">
                <span>
                    <input type="radio" id="radio-mocktail" name="mocktail">
                    <label for="radio-mocktail" title="Cocktail sans alcool">Mocktails</label>
                </span>
            </div>
        </nav>

        <section id="galerie"></section>
        <div id="gif-loading" style="display: none;margin: auto;">
            <img src="ressources/images/1486.gif" alt="Chargement">
        </div>
    </main>

    <aside id="contenant-modale"></aside>


    <footer>Cocktail Wizard &copy - 2024</footer>
    <script src="ressources/scripts/outils.js"></script>
    <script src="ressources/scripts/index.js"></script>
    <script src="ressources/scripts/modale.js"></script>
</body>

</html>

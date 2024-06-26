<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galerie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="ressources/styles/main.css">
    <link rel="stylesheet" href="ressources/styles/index.css">
    <link rel="stylesheet" href="ressources/styles/modale.css">
    <link rel="stylesheet" href="ressources/styles/publication.css">
    <link rel="stylesheet" href="ressources/styles/userprofile.css">
    <link rel="stylesheet" href="ressources/styles/carte_cocktail.css">
</head>

<body>
    <noscript class="erreur">Vous devez activer JavaScript pour charger ce site web.</noscript>

    <header id="top">
        <div class="user">
            <button type="button" title="Profile" id="profil-utilisateur" data-bs-toggle="modal" data-bs-target="#my-modal">
                <img class="profile-pic" src="ressources/images/1486.gif" alt="Profile Picture">
            </button>
            <button class="button" id="bouton-deconnexion" style="display: none;">Déconnexion</button>
        </div>

        <h1 class="neonText-pink">COCKTAIL WIZARD</h1>
        <div class="button-container">
            <a id="bouton-monbar" href="/monbar">
                <img class="monbar-pic" src="../ressources/images/icone-monbar.svg" alt="Mon bar">
            </a>
        </div>
    </header>

    <main>
        <nav>
            <div class="nav-top">
                <input id="barre-recherche" type="text" placeholder="Recherchez un cocktail..." autocomplete="off">
                <button id="ordre-tri" title="Ordonner par mentions j'aime">
                    <img id="ordre-tri-icone" src="ressources/images/icone-calendrier.svg" alt="Ordre">
                    <img src="ressources/images/tete-fleche-bas.svg" alt="Ordre décroissant">
                </button>
            </div>
            <div class="nav-radio">
                <span>
                    <input type="radio" id="radio-perso" name="cocktail">
                    <label for="radio-perso">Cocktails réalisables</label>
                </span>
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

    <aside id="deux-boutons">
        <button type="button" id="publish" data-bs-toggle="modal" data-bs-target="#mon-modal">
            <img id="btnPublish" src="../ressources/images/feather.svg" alt="Feather" width="24" height="24">
        </button>
    </aside>

    <?php require_once(__DIR__ . "/../ressources/modeles/modale_publication.php") ?>
    <?php require_once(__DIR__ . "/../ressources/modeles/modale_profilUtilisateur.php") ?>

    <footer>Cocktail Wizard &copy - 2024</footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="ressources/scripts/outils.js"></script>
    <script src="ressources/scripts/index.js"></script>
    <script src="ressources/scripts/modale.js"></script>
    <script type="module" src="ressources/scripts/publication.js"></script>
    <script src="../ressources/scripts/userprofile.js"></script>
</body>

</html>

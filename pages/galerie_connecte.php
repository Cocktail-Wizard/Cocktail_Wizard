<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galerie</title>
    <link rel="stylesheet" href="ressources/styles/main.css">
    <link rel="stylesheet" href="ressources/styles/index.css">
    <link rel="stylesheet" href="ressources/styles/modale.css">
    <link rel="stylesheet" href="ressources/styles/carte_cocktail.css">
    <link rel="stylesheet" href="../ressources/styles/publication.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="ressources/scripts/outils.js"></script>
</head>

<body>
    <noscript class="erreur">Vous devez activer JavaScript pour charger ce site web.</noscript>

    <header>
        <h1>Cocktail Wizard</h1>
    </header>

    <main>
        <nav>
            <input id="barre-recherche" type="text" placeholder="Recherchez un cocktail..." autocomplete="off" autofocus>
            <button id="ordre-tri" title="Ordonner par mentions j'aime">
                <img id="ordre-tri-icone" alt="Ordre">
                <img src="ressources/images/tete-fleche-bas.svg" alt="Ordre décroissant">
            </button>
        </nav>

        <section id="galerie"></section>
    </main>

    <aside id="contenant-modale"></aside>

    <aside id="contenant-boutons-fixes">
        <a href="/connexion" title="Connexion">
            <img src="ressources/images/icone-profile.svg" alt="Icone profile">
        </a>
        <a href="/monbar" title="Mon bar" id="lien-monbar">
            <img src="ressources/images/icone-monbar.svg" alt="Mon bar">
        </a>
    </aside>

    <aside id="deux-boutons">
        <button>
            <img id="btnAbout" src="../ressources/images/info.svg" alt="Question Mark" width="24" height="24">
        </button>
        <button type="button" id="publish" data-bs-toggle="modal" data-bs-target="#monModal">
            <img id="btnPublish" src="../ressources/images/feather.svg" alt="Feather" width="24" height="24">
        </button>

    </aside>

        <!-- Le modal -->
    <div id="monModal" class="modal fade">
        <div class="modal-dialog modal-xl">
            <!-- Contenu du modal -->
            <div id="publication-content" class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Créer un cocktail</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">&times;</button>
                    <!-- symbole x pour fermer -->
                </div>

                <div class="modal-body" id="page-publication">

                    <form>
                        <label for="nom-cocktail">Nom du cocktail:</label><br>
                        <textarea id="name-texte" name="nom-cocktail" rows="1" cols="50"></textarea><br>

                        <label for="ingredient-cocktail">Ingrédients:</label><br>
                        <div id="ingredient-input">
                            <div id="add-form">
                                <input type="text" id="ingredient-nom" placeholder="Nom de l'ingrédient...">
                                <input type="text" id="ingredient-quantite" placeholder="Quantité...">
                                <input type="text" id="ingredient-unit" placeholder="Unité...">

                                <button type="button" class="button-publish" id="ajouter-ingredient">
                                    <img class="btn-icon" src="../ressources/images/plus.svg" alt="+">
                                </button>

                            </div>

                            <div id="liste-ingredients-publish"></div>

                        </div>

                        <br>

                        <label for="preparation-cocktail">Préparation:</label><br>
                        <textarea id="preparation-texte" name="preparation-cocktail" rows="4" cols="50" placeholder="Expliquez-nous comment créer votre fabuleuse création, les étapes, la méthode et, si jamais vous avez des petites notes à rajouter, faites-nous en part!"></textarea><br>


                        <label for="description-cocktail">Description:</label><br>
                        <textarea id="description-texte" name="description-cocktail" rows="4" cols="50" placeholder="Une description n'est pas nécessaire, mais elle permet à notre communauté de voir à travers vos yeux."></textarea><br>

                        <div id="dropdown-choices">
                            <label for="flavor-profile">Profil de saveur:</label>
                            <select name="flavor-profile" id="flavor">
                                <option value="sucre" selected>sucré</option>
                                <option value="sale">salée</option>
                                <option value="amer">amer</option>
                                <option value="epice">epicé</option>
                                <option value="acide">acide</option>
                            </select>
                            <label for="main-alcool">Alcool principal:</label>
                            <select name="main-alcool" id="alcool">
                                <option value="vodka" selected>vodka</option>
                                <option value="gin">gin</option>
                                <option value="whiskey">whiskey</option>
                                <option value="tequila">tequila</option>
                                <option value="rhum">rhum</option>
                                <option value="aperitif">apéritif</option>
                                <option value="liqueur">liqueur</option>
                            </select>
                        </div>

                        <br>

                        <label for="cocktail-image">Photo de votre cocktail:</label><br>
                        <input type="file" accept="image/*" onchange="previewImage(event)" />
                        <img id="preview" src="#" alt="Votre image" />

                        <input type="submit" value="Publier">
                    </form>

                </div>
            </div>
        </div>
    </div>

    <footer>Cocktail Wizard &copy - 2024</footer>

    <script src="ressources/scripts/index.js"></script>
    <script src="ressources/scripts/modale.js"></script>
    <script src="../ressources/scripts/outils.js"></script>
    <script type="module" src="../ressources/scripts/publication.js"></script>
</body>

</html>

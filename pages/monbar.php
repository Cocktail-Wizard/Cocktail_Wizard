<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon bar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../ressources/styles/main.css">
    <link rel="stylesheet" href="../ressources/styles/monbar.css">
    <link rel="stylesheet" href="../ressources/styles/carte_cocktail.css">
    <link rel="stylesheet" href="../ressources/styles/publication.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <noscript class="erreur">Vous devez activer JavaScript pour charger ce site web.</noscript>

    <header id="top">
        <div class="user">
            <span id="backgroundshape"></span>
            <div class="profile-pic-container">
                <img class="profile-pic" src="../ressources/images/lionWizard.jpg" alt="Profile Picture">
            </div>
            <span class="username">@UsernameSuperWizard</span>
            <button class="button" id="bouton-deconnexion" style="display: none;">Déconnexion</button>
        </div>

        <h1>Cocktail <img src="../favicon.ico" id="w-icon">izard</h1>
        <div class="button-container">
            <a class="button" id="bouton-galerie" href="../index.html">Galerie</a>
        </div>
    </header>

    <hr>

    <main>
        <div class="separator">
            <span class="section-name">Mes ingredients</span>
            <hr class="line right" />

            <section class="ingredients">
                <div id="contenant-boite-recherche" class="dropdown">
                    <input type="text" id="boite-recherche" placeholder="Ajouter un ingredient...">
                    <div id="liste-ingredients" class="dropdown-content"></div>
                </div>
            </section>
        </div>
        <div class="boite-ingredients-selectionnes" id="ingredients-selectionne"></div>
        <div class="body">
            <div class="separator">
                <span class="section-name">Les classiques</span>
                <hr class="line right" />
            </div>

            <section id="cocktails-classiques" class="galerie"></section>

            <div class="separator">
                <span class="section-name">Mes favoris</span>
                <hr class="line right" />
            </div>

            <section id="cocktails-personnels" class="galerie"></section>

            <div class="separator">
                <span class="section-name">Communautaires</span>
                <hr class="line right" />
            </div>

            <section id="cocktails-communautaires" class="galerie"></section>

        </div>
    </main>

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

                                <button class="button-publish" id="ajouter-ingredient">
                                    <img class="btn-icon" src="../ressources/images/plus.svg" alt="+">
                                </button>
                            </div>

                            <div id="liste-ingredients"></div>

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

    <script src="../ressources/scripts/outils.js"></script>
    <script type="module" src="../ressources/scripts/publication.js"></script>
    <script type="module" src="../ressources/scripts/monbar.js"></script>

</body>

</html>

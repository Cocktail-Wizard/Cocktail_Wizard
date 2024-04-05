<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon bar</title>
    <link rel="stylesheet" href="../ressources/styles/main.css">
    <link rel="stylesheet" href="../ressources/styles/monbar.css">
    <link rel="stylesheet" href="../ressources/styles/carte_cocktail.css">
    <link rel="stylesheet" href="../ressources/styles/userprofile.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <noscript class="erreur">Vous devez activer JavaScript pour charger ce site web.</noscript>

    <header id="top">
        <div class="user">
            <span id="backgroundshape"></span>

            <button type="button" class="profile-pic-container" data-bs-toggle="modal" data-bs-target="#my-modal">
                <img class="profile-pic" src="../ressources/images/lionWizard.jpg" alt="Profile Picture">
            </button>

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
        <div class="boite-ingredients-selectionnes" id="selectedIngredients"></div>
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

    <!-- Modale pour le profil utilisateur -->
    <!-- la page modale -->
    <div id="my-modal" class="modal">
        <div class="modal-dialog modal-xl">
            <!-- Contenue de la boite modale -->
            <div id="userprofile-content" class="modal-content">
                <div class="modal-header">
                    <div id="userprofile-header">
                        <button id="info-btn">Info personnelle</button>
                        <button id="cocktail-btn">Mes cocktails</button>
                        <button id="support-btn">Support</button>
                    </div>
                    <button type="button" id="fuck-bootstrap" class="btn-close" data-bs-dismiss="modal"></button>
                    <!-- symbole x pour fermer -->
                </div>

                <div class="modal-body">
                    <div class="userinfo-body" id="infoPage">
                        <img src="../ressources/images/lionWizard.jpg" alt="Photo de profil de l'utilisateur">
                        <h3>Nom de l'utilisateur: Lionel Wizard</h3>
                        <p>Nombre de likes : <span id="likeCount">0</span></p>
                        <p>Nombre de cocktails : <span id="cocktailCount">0</span></p>
                        <p>Nombre de commentaires : <span id="commentCount">0</span></p>
                    </div>

                    <div class="mycocktail-body" id="mycocktailPage">
                        <div class="cocktail-container">
                            <!-- Les cartes de cocktail seront ajoutées ici -->
                        </div>
                    </div>

                    <div class="support-body" id="supportPage">

                        <h2 style="color: #7f5af0;">Contactez-nous</h2>

                        <form action="../ressources/email.php" method="post">
                            <label for="message">Message:</label><br>
                            <textarea id="message" name="message" rows="4" cols="50"></textarea><br>
                            <input id="submit-btn" type="submit" value="Envoyer">
                        </form>

                    </div>
                </div>
                <div class="userprofile-footer">
                    <h3>Cocktail Wizard &copy - 2024</h3>
                </div>
            </div>
        </div>
    </div>

    <aside id="deux-boutons">
        <button>
            <img id="btnAbout" src="../ressources/images/info.svg" alt="Info de la page">
        </button>
        <button>
            <img id="btnPublish" src="../ressources/images/feather.svg" alt="Publication">
        </button>
    </aside>

    <footer>Cocktail Wizard &copy - 2024</footer>

    <script src="../ressources/scripts/userprofile.js"></script>
    <script src="../ressources/scripts/outils.js"></script>
    <script src="../ressources/scripts/monbar.js"></script>
</body>

</html>

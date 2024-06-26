<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: /connexion");
    exit();
}
?>
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
    <link rel="stylesheet" href="../ressources/styles/userprofile.css">
    <link rel="stylesheet" href="../ressources/styles/publication.css">
    <link rel="stylesheet" href="../ressources/styles/modale.css">

</head>

<body>
    <noscript class="erreur">Vous devez activer JavaScript pour charger ce site web.</noscript>

    <header id="top">
        <div class="user">
            <button type="button" id="profil-utilisateur" title="Profile" data-bs-toggle="modal" data-bs-target="#my-modal">
                <img class="profile-pic" src="ressources/images/1486.gif" alt="Profile Picture">
            </button>
            <button class="button" id="bouton-deconnexion" style="display: none;">Déconnexion</button>
        </div>

        <h1>COCKTAIL WIZARD</h1>
        <div class="button-container">
            <a id="bouton-galerie" href="/galerie">
                <img class="galerie-pic" src="../ressources/images/icone-galerie.svg" alt="Galerie de cocktails">
            </a>
        </div>
    </header>



    <main>
        <div class="separator">
            <span class="neonText-pink-smol section-name neon-blue-low">Mes ingrédients</span>
            <hr class="line neon-blue-low" />


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
                <span class=" neonText-pink-smol section-name neon-blue-low">Les classiques</span>
                <hr class="line neon-blue-low" />
            </div>
            <div class="conteneur-carte-cocktail" id="conteneur-classique">

            </div>


            <div class="separator">
                <span class=" neonText-pink-smol section-name neon-blue-low">Mes favoris</span>
                <hr class="line neon-blue-low" />
            </div>
            <div class="conteneur-carte-cocktail" id="conteneur-favoris"></div>

            <div class="separator">
                <span class="neonText-pink-smol section-name neon-blue-low">Communautaires</span>
                <hr class="line neon-blue-low" />
            </div>
            <div class="conteneur-carte-cocktail" id="conteneur-communautaires"></div>


        </div>
    </main>

    <aside id="deux-boutons">
        <button type="button" id="publish" data-bs-toggle="modal" data-bs-target="#mon-modal">
            <img id="btnPublish" src="../ressources/images/feather.svg" alt="Modale de publication">
        </button>
    </aside>

    <aside id="contenant-modale"></aside>

    <?php require_once(__DIR__ . "/../ressources/modeles/modale_publication.php") ?>
    <?php require_once(__DIR__ . "/../ressources/modeles/modale_profilUtilisateur.php") ?>

    <footer>Cocktail Wizard &copy - 2024</footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../ressources/scripts/outils.js"></script>
    <script src="../ressources/scripts/modale.js"></script>
    <script type="module" src="../ressources/scripts/publication.js"></script>
    <script src="../ressources/scripts/monbar.js"></script>
    <script src="../ressources/scripts/userprofile.js"></script>


</body>

</html>

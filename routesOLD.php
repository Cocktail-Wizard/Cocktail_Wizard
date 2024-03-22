<?php
/*
* Implémentantion du système de routage
*/
$uri = $_SERVER['REQUEST_URI'];
$param = $_SERVER['QUERY_STRING'];
$methode = $_SERVER['REQUEST_METHOD'];

//Routes dynamiques
if($methode == "POST") {
    //Stockage des données reçues dans une variable
    $json = file_get_contents('php://input');
    $donnees = json_decode($json, true);

    //Récupération de la requête
    $requete = trim(parse_url($uri, PHP_URL_PATH), '/');
    //Séparation de la requête en un tableau
    $requete_separee = explode('/', $requete);


    if(isset($requete_separee[1])){

        switch($requete_separee[1]){

            case 'users':
                // /api/users/authentification ->Connexion d'un utilisateur
                if(isset($requete_separee[2]) && $requete_separee[2] == 'authentification'){
                    require __DIR__ . '/ressources/api/connexion.php';
                }
                // /api/users -> Inscription d'un utilisateur
                elseif(!isset($requete_separee[2])) {
                    require __DIR__ . '/ressources/api/inscription.php';
                }
                else {
                    http_response_code(404);
                    echo json_encode("requête invalide.");
                }
                break;
            case 'cocktails':
                // /api/cocktails/like ->Like d'un cocktail
                if(isset($requete_separee[2]) && $requete_separee[2] == 'like'){
                    require __DIR__ . '/ressources/api/likeCocktail.php';
                }
                // /api/cocktails/dislike ->Dislike d'un cocktail
                elseif(isset($requete_separee[2]) && $requete_separee[2] == 'dislike'){
                    require __DIR__ . '/ressources/api/dislikeCocktail.php';
                }
                // /api/cocktails/commentaires
                elseif(isset($requete_separee[2]) && $requete_separee[2] == 'commentaires'){
                    // /api/cocktails/commentaires/like ->Like d'un commentaire
                    if(isset($requete_separee[3]) && $requete_separee[3] == 'like'){
                        require __DIR__ . '/ressources/api/likeCommentaire.php';
                    }
                    // /api/cocktails/commentaires/dislike ->Dislike d'un commentaire
                    elseif(isset($requete_separee[3]) && $requete_separee[3] == 'dislike'){
                        require __DIR__ . '/ressources/api/dislikeCommentaire.php';
                    }
                    // /api/cocktails/commentaires ->Ajout d'un commentaire
                    elseif(!isset($requete_separee[3])) {
                        require __DIR__ . '/ressources/api/ajouterCommentaire.php';
                    }
                    else {
                        http_response_code(404);
                        echo json_encode("requête invalide.");
                    }
                }
                // /api/cocktails ->Ajout d'un cocktail
                elseif(!isset($requete_separee[2])) {
                    require __DIR__ . '/ressources/api/ajouterCocktail.php';
                }
                else {
                    http_response_code(404);
                    echo json_encode("requête invalide.");
                }
                break;
            // /api/ingredients ->Ajout d'un ingrédient dans mon bar
            case 'ingredients':
                require __DIR__ . '/ressources/api/ajouterIngredientMonBar.php';
                break;
            default:
                http_response_code(404);
                echo json_encode("requête invalide.");
                break;
        }
    }
}
//Routes dynamiques
else if($methode == "GET") {

    //Récupération de la requête
    $requete = trim(parse_url($uri, PHP_URL_PATH), '/');
    //Séparation de la requête en un tableau
    $requete_separee = explode('/', $requete);

    switch ($requete_separee[1]) {
        // /api/cocktails
        case 'cocktails':
            if (isset($_GET['tri'])) {
                $tri = $_GET['tri'];
                // /api/cocktails?tri=like ->Cocktails galerie par like..
                if ($tri == 'like') {
                    require __DIR__ . '/ressources/api/getCocktailParLike.php';
                }
                // /api/cocktails?tri=date ->Cocktails galerie par date..
                elseif ($tri == 'date') {
                    require __DIR__ . '/ressources/api/getCocktailParDate.php';
                }
                else {
                    http_response_code(400);
                    echo json_encode("Paramètre de triage invalide.");
                }
            }
            // /api/cocktails?recherche=mots_cles ->Recherche de cocktails sans filtre..
            elseif (isset($_GET['recherche'])) {
                $mots_cles = $_GET['recherche'];
                require __DIR__ . '/ressources/api/rechercheCocktail.php';
            }
            else {
                http_response_code(400);
                echo json_encode("Requête invalide.");
            }
            break;
        case 'users':
            $username = $requete_separee[2]; //Verifier isset
            // /api/users/{username}/recommandations?tri=tri&type=type -> Cocktail qu'un utilisateur peut faire. Pour mon bar et galerie connecté..
            if (isset($_GET['type']) && isset($requete_separee[3]) && $requete_separee[3] == 'recommandations') {
                $type = $_GET['type'];
                require __DIR__ . '/ressources/api/getUserRecommandations.php';
            }
            // /api/users/{username}/recommandations?recherche=mots_cles ->Recherche de cocktail qu'un utilisateur peut faire..
            elseif (isset($_GET['recherche']) && $requete_separee[3] == 'recommandations') {
                $mots_cles = $_GET['recherche'];
                require __DIR__ . '/ressources/api/rechercheUserRecommandations.php';
            }
            // /api/users/{username}/ingredients ->Ingrédients dans mon bar
            elseif ($requete_separee[3] == 'ingredients') {
                require __DIR__ . '/ressources/api/getUserIngredients.php';
            }
            // /api/users/{username}/cocktails -> Cocktail qu'un utilisateur a créé(Profil)
            elseif ($requete_separee[3] == 'cocktails') {
                require __DIR__ . '/ressources/api/getUserCocktails.php';
            }
            // /api/users/{username} ->Information d'un utilisateur(Profil)
            elseif(!isset($requete_separee[3])) {
                require __DIR__ . '/ressources/api/getUserInfo.php';
            }
            else {
                http_response_code(404);
                echo json_encode("Requête invalide.");
            }
            break;
        case 'ingredients':
            // /api/ingredients ->Liste des ingrédients disponibles(Mon bar ou création de cocktail)
            require __DIR__ . '/ressources/api/getIngredients.php';
            break;
        default:
            http_response_code(404);
            echo json_encode("$uri");
            break;
    }
}

else if($methode == "DELETE") {
    $json = file_get_contents('php://input');
    $donnees = json_decode($json, true);

    //TODO
}
// Routes statiques
else {
    switch ($uri) {
        case '/':
        case '/galerie':
            if (isset($_SESSION['id_utilisateur'])) {
                require __DIR__ . '/pages/galerie_connecte.php';
            }
            else {
                require __DIR__ . '/pages/galerie.php';
            }
            break;
        case '/inscription':
            require __DIR__ . '/pages/inscription.php';
            break;
        case '/connexion':
            require __DIR__ . '/pages/connexion.php';
            break;
        case '/monbar' :
            if(isset($_SESSION['id_utilisateur'])){
                require __DIR__ . '/pages/monbar.php';

            }
            else{
                require __DIR__ . '/pages/connexion.php';
            }
            break;
        case '/profile':
            if(isset($_SESSION['id_utilisateur'])){
                require __DIR__ . '/pages/profile.php';
            }
            else{
                require __DIR__ . '/pages/connexion.php';
            }
            break;
        default:
            http_response_code(404);
            require __DIR__ . '/pages/404.php';
            break;
    }
}
?>

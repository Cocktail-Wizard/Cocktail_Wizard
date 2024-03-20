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
                // /api/users/authentification
                if(isset($requete_separee[2]) && $requete_separee[2] == 'authentification'){
                    require __DIR__ . '/api/connexion.php';
                }
                // /api/users
                elseif(!isset($requete_separee[2])) {
                    require __DIR__ . '/api/inscription.php';
                }
                else {
                    http_response_code(404);
                    echo json_encode("requête invalide.");
                }
                break;
            case 'cocktails':
                // /api/cocktails/like
                if(isset($requete_separee[2]) && $requete_separee[2] == 'like'){
                    require __DIR__ . '/api/likeCocktail.php';
                }
                // /api/cocktails/dislike
                elseif(isset($requete_separee[2]) && $requete_separee[2] == 'dislike'){
                    require __DIR__ . '/api/dislikeCocktail.php';
                }
                // /api/cocktails/commentaires
                elseif(isset($requete_separee[2]) && $requete_separee[2] == 'commentaires'){
                    // /api/cocktails/commentaires/like
                    if(isset($requete_separee[3]) && $requete_separee[3] == 'like'){
                        require __DIR__ . '/api/likeCommentaire.php';
                    }
                    // /api/cocktails/commentaires/dislike
                    elseif(isset($requete_separee[3]) && $requete_separee[3] == 'dislike'){
                        require __DIR__ . '/api/dislikeCommentaire.php';
                    }
                    // /api/cocktails/commentaires
                    elseif(!isset($requete_separee[3])) {
                        require __DIR__ . '/api/ajouterCommentaire.php';
                    }
                    else {
                        http_response_code(404);
                        echo json_encode("requête invalide.");
                    }
                }
                // /api/cocktails
                elseif(!isset($requete_separee[2])) {
                    require __DIR__ . '/api/ajouterCocktail.php';
                }
                else {
                    http_response_code(404);
                    echo json_encode("requête invalide.");
                }
                break;
            // /api/ingredients
            case 'ingredients':
                require __DIR__ . '/api/ajouterIngredientMonBar.php';
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
                // /api/cocktails?tri=like
                if ($tri == 'like') {
                    require __DIR__ . '/api/getCocktailParLike.php';
                }
                // /api/cocktails?tri=date
                elseif ($tri == 'date') {
                    require __DIR__ . '/api/getCocktailParDate.php';
                }
                else {
                    http_response_code(400);
                    echo json_encode("Paramètre de triage invalide.");
                }
            }
            // /api/cocktails?recherche=mots_cles
            elseif (isset($_GET['recherche'])) {
                $mots_cles = $_GET['recherche'];
                require __DIR__ . '/api/rechercheCocktail.php';
            }
            else {
                http_response_code(400);
                echo json_encode("Requête invalide.");
            }
            break;
        case 'users':
            $username = $requete_separee[2];
            // /api/users/{username}/recommandations?tri=tri&type=type
            if (isset($_GET['tri']) && isset($_GET['type']) && isset($requete_separee[3]) && $requete_separee[3] == 'recommandations') {
                $tri = $_GET['tri'];
                $type = $_GET['type'];
                require __DIR__ . '/api/getUserRecommandations.php';
            }
            // /api/users/{username}/recommandations?recherche=mots_cles
            elseif (isset($_GET['recherche']) && $requete_separee[3] == 'recommandations') {
                $mots_cles = $_GET['recherche'];
                require __DIR__ . '/api/rechercheUserRecommandations.php';
            }
            // /api/users/{username}/ingredients
            elseif ($requete_separee[3] == 'ingredients') {
                require __DIR__ . '/api/getUserIngredients.php';
            }
            // /api/users/{username}/cocktails
            elseif ($requete_separee[3] == 'cocktails') {
                require __DIR__ . '/api/getUserCocktails.php';
            }
            // /api/users/{username}
            elseif(!isset($requete_separee[3])) {
                require __DIR__ . '/api/getUserInfo.php';
            }
            else {
                http_response_code(404);
                echo json_encode("Requête invalide.");
            }
            break;
        case 'ingredients':
            require __DIR__ . '/api/getIngredients.php';
            break;
        default:
            http_response_code(404);
            echo json_encode("Invalid request.");
            break;
    }
}

else if($_SERVER["REQUEST_METHOD"]== "DELETE") {
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

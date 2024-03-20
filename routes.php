<?php
/*
* Implémentantion du système de routage
*/
$uri = $_SERVER['REQUEST_URI'];
$param = $_SERVER['QUERY_STRING'];
$methode = $_SERVER['REQUEST_METHOD'];

//Routes dynamiques
if($methode == "POST") {
    $json = file_get_contents('php://input');
    $donnees = json_decode($json, true);

    $requete = trim(parse_url($uri, PHP_URL_PATH), '/');
    $requete_separee = explode('/', $requete);

    //Passer dans le JSON le type d'action à effectuer
    if(isset($requete_separee[1])){
        switch($requete_separee[1]){
            case 'users':
                if(isset($requete_separee[2]) && $requete_separee[2] == 'authentification'){
                    require __DIR__ . '/api/connexion.php';
                }
                elseif(!isset($requete_separee[2])) {
                    require __DIR__ . '/api/inscription.php';
                }
                else {
                    http_response_code(404);
                    echo json_encode("requête invalide.");
                }
                break;
            case 'cocktails':
                if(isset($requete_separee[2]) && $requete_separee[2] == 'like'){
                    require __DIR__ . '/api/likeCocktail.php';
                }
                elseif(isset($requete_separee[2]) && $requete_separee[2] == 'dislike'){
                    require __DIR__ . '/api/dislikeCocktail.php';
                }
                elseif(isset($requete_separee[2]) && $requete_separee[2] == 'commentaires'){

                    if(isset($requete_separee[3]) && $requete_separee[3] == 'like'){
                        require __DIR__ . '/api/likeCommentaire.php';
                    }
                    elseif(isset($requete_separee[3]) && $requete_separee[3] == 'dislike'){
                        require __DIR__ . '/api/dislikeCommentaire.php';
                    }
                    elseif(!isset($requete_separee[3])) {
                        require __DIR__ . '/api/ajouterCommentaire.php';
                    }
                    else {
                        http_response_code(404);
                        echo json_encode("requête invalide.");
                    }
                }
                elseif(!isset($requete_separee[2])) {
                    require __DIR__ . '/api/ajouterCocktail.php';
                }
                else {
                    http_response_code(404);
                    echo json_encode("requête invalide.");
                }
                break;
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
// Pour les requêtes GET, les informations nécessaires pour effectuer l'action
// sont passées dans l'URL et non en JSON.
else if($methode == "GET") {

    $requete = trim(parse_url($uri, PHP_URL_PATH), '/');
    $requete_separee = explode('/', $requete);

    switch ($requete_separee[1]) {
        case 'cocktails':
            if (isset($_GET['tri'])) {
                $tri = $_GET['tri'];
                if ($tri == 'like') {
                    require __DIR__ . '/api/getCocktailParLike.php';
                } elseif ($tri == 'date') {
                    require __DIR__ . '/api/getCocktailParDate.php';
                } else {
                    http_response_code(400);
                    echo json_encode("Paramètre de triage invalide.");
                }
            } elseif (isset($_GET['recherche'])) {
                $mots_cles = $_GET['recherche'];
                require __DIR__ . '/api/rechercheCocktail.php';
            } else {
                http_response_code(400);
                echo json_encode("Requête invalide.");
            }
            break;
        case 'users':
            $username = $requete_separee[2];
            if (isset($_GET['tri']) && isset($_GET['type']) && $requete_separee[3] == 'recommandations') {
                $tri = $_GET['tri'];
                $type = $_GET['type'];
                require __DIR__ . '/api/getUserRecommandations.php';
            } elseif (isset($_GET['recherche']) && $requete_separee[3] == 'recommandations') {
                $mots_cles = $_GET['recherche'];
                require __DIR__ . '/api/rechercheUserRecommandations.php';
            } elseif ($requete_separee[3] == 'ingredients') {
                require __DIR__ . '/api/getUserIngredients.php';
            } elseif ($requete_separee[3] == 'cocktails') {
                require __DIR__ . '/api/getUserCocktails.php';
            } else {
                require __DIR__ . '/api/getUserInfo.php';
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


} else if($_SERVER["REQUEST_METHOD"]== "DELETE") {
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

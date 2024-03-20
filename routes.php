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
    //Passer dans le JSON le type d'action à effectuer
    switch ($donnees['action']) {
        case 'cocktail':
            require __DIR__ . '/api/postCocktail.php';
            break;
        case 'commentaire':
            require __DIR__ . '/api/postCommentaire.php';
            break;
        case 'inscription':
            require __DIR__ . '/api/Inscription.php';
            break;
        default:
            http_response_code(404);
            echo json_encode("Requête invalide.");
            break;
    }
}
// Pour les requêtes GET, les informations nécessaires pour effectuer l'action
// sont passées dans l'URL et non en JSON.
else if($methode == "GET") {

    $requete = trim(parse_url($uri, PHP_URL_PATH), '/');

    $requete_separee = explode('/', $requete);

    switch ($requete_separee[1]) {
        case 'cocktails':
            require __DIR__ . '/api/getCocktail.php';
            break;
        case 'ingredients':
            require __DIR__ . '/api/getIngredient.php';
            break;
        case 'users':
            if($requete_separee[2] == 'cocktails')
                require __DIR__ . '/api/getCocktail.php';
            else
                require __DIR__ . '/api/getUser.php';
            break;
        default:
            http_response_code(404);
            echo json_encode("Requête invalide.");
            break;
    }

    /*
    // Passer dans l'URL les informations nécessaires pour effectuer l'action
    $typeGet = $_GET['type'];
    switch ($typeGet) {
        // Aller checher le reste des informations du GET dans l'URL directement
        // dans le fichier .php
        case 'cocktail':
            require __DIR__ . '/api/getCocktail.php';
            break;
        case 'Ingredient':
            // Possibilité de passer dans l'URL la fonction à effectuer
            // et d'appeler une procédure stockée sql différente dans getIngredient.php
            // Par ex: GetListeIngredients pour obtenir la liste des ingrédients à ajouter
            // dans mon bar ou pour un cocktail. Sinon, GetMesIngredients pour obtenir
            // la liste des ingrédients que l'utilisateur a déjà dans son bar.
            require __DIR__ . '/api/getIngredient.php';
            break;
    }
    */
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

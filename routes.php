<?php

require_once __DIR__ . '/router.php';

// Static GET
// The output -> Index
get('/', 'index.php');

// Static GET
// /galerie -> Galerie de cocktails
get('/galerie', 'index.php');

// Static GET
// /inscription -> Page d'inscription
get('/inscription', 'pages/inscription.php');

// Static GET
// /connexion -> Page de connexion
get('/connexion', 'pages/connexion.php');

// Static GET
// /monbar -> Page de mon bar
get('/monbar', 'pages/monbar.php');

// Static GET
// /profile -> Page de profil
get('/profile', 'pages/profile.php');

/******POST*******/

// /api/users/authentification ->Connexion d'un utilisateur
post('/api/users/authentification', 'ressources/api/connexion.php');

// /api/users -> Inscription d'un utilisateur
post('/api/users', 'ressources/api/inscription.php');

// /api/cocktails/like ->Like d'un cocktail
// L'API retourne le nouveau nombre de likes
post('/api/cocktails/like', 'ressources/api/likeCocktail.php');

// /api/cocktails/commentaires/like ->Like d'un commentaire
// L'API retourne le nouveau nombre de likes
post('/api/cocktails/commentaires/like', 'ressources/api/likeCommentaire.php');

// /api/cocktails/commentaires ->Ajout d'un commentaire
// L'API retourne une nouvel liste de commentaires
post('/api/cocktails/commentaires', 'ressources/api/ajouterCommentaire.php');

// /api/cocktails ->Ajout d'un cocktail
post('/api/cocktails', 'ressources/api/ajouterCocktail.php');

// /api/user/ingredients ->Ajout d'un ingrédient dans mon bar
post('/api/users/ingredients', 'ressources/api/ajouterIngredientMonBar.php');

/******GET*********/

// /api/cocktails/tri/${like/date}  ->Cocktails galerie
get('/api/cocktails/tri/$tri', 'ressources/api/getCocktails.php');

// /api/cocktails/tri/{like/date}/recherche/{mot-clé, mot-clé, mot-clé}
//->Recherche de cocktails sans filtre
get('/api/cocktails/tri/$tri/recherche/$mots', 'ressources/api/rechercheCocktail.php');

// /api/users/{username}/recommandations/recherche/{mot-clé, mot-clé, mot-clé}
//  ->Recherche de cocktails recommandés
get('/api/users/$username/cocktails/tri/$tri/recherche/$mots', '/ressources/api/rechercheUserRecommandations.php');

// /api/users/{username}/recommandations/tri/{like/date}
// ->Liste des cocktails que l'utilisateur peut faire avec ses ingrédients. Pour galerie connectée
get('/api/users/$username/recommandations/tri/$tri', '/ressources/api/getUserRecommandations.php');

// /api/users/{username}/recommandations/type/{classiques/favoris/communaute}
// ->Liste des cocktails que l'utilisateur peut faire avec ses ingrédients. Pour mon bar
get('/api/users/$username/recommandations/type/$type', '/ressources/api/getUserRecommandations.php');

// /api/users/{username}/ingredients ->Liste des ingrédients de mon bar
get('/api/users/$username/ingredients', '/ressources/api/getUserIngredients.php');

// /api/users/{username}/cocktails ->Liste des cocktails de l'utilisateur
get('/api/users/$username/cocktails', '/ressources/api/getUserCocktails.php');

// /api/user/{username} ->Profil utilisateur
get('/api/users/$username', '/ressources/api/getUserInfo.php');

// /api/ingredients ->Liste des ingrédients de la base de données(Mon bar ou Création de cocktail)
get('/api/ingredients', '/ressources/api/getIngredients.php');

// /api/cocktails/{id_cocktail}/commentaires ->Liste des commentaires d'un cocktail
get('/api/cocktails/$id_cocktail/commentaires', '/ressources/api/getCocktailCommentaires.php');

/**********DELETE ************/

// /api/users/ingredients ->Suppression d'un ingrédient de mon bar
delete('/api/users/ingredients', '/ressources/api/enleverIngredientMonBar.php');

// /api/cocktails/commentaires/dislike ->Dislike d'un commentaire
// L'API retourne le nouveau nombre de likes
delete('/api/cocktails/commentaires/like', 'ressources/api/dislikeCommentaire.php');

// /api/cocktails/dislike ->Dislike d'un cocktail
// L'API retourne le nouveau nombre de like
delete('/api/cocktails/like', 'ressources/api/dislikeCocktail.php');

/*
// Dynamic GET. Example with 1 variable
// The $id will be available in user.php
get('/user/$id', 'views/user');

// Dynamic GET. Example with 2 variables
// The $name will be available in full_name.php
// The $last_name will be available in full_name.php
// In the browser point to: localhost/user/X/Y
get('/user/$name/$last_name', 'views/full_name.php');

// Dynamic GET. Example with 2 variables with static
// In the URL -> http://localhost/product/shoes/color/blue
// The $type will be available in product.php
// The $color will be available in product.php
get('/product/$type/color/$color', 'product.php');

// A route with a callback
get('/callback', function(){
  echo 'Callback executed';
});

// A route with a callback passing a variable
// To run this route, in the browser type:
// http://localhost/user/A
get('/callback/$name', function($name){
  echo "Callback executed. The name is $name";
});

// Route where the query string happends right after a forward slash
get('/product', '');

// A route with a callback passing 2 variables
// To run this route, in the browser type:
// http://localhost/callback/A/B
get('/callback/$name/$last_name', function($name, $last_name){
  echo "Callback executed. The full name is $name $last_name";
});

// ##################################################
// ##################################################
// ##################################################
// Route that will use POST data
post('/user', '/api/save_user');



// ##################################################
// ##################################################
// ##################################################
// any can be used for GETs or POSTs
*/
// For GET or POST
// The 404.php which is inside the views folder will be called
// The 404.php has access to $_GET and $_POST
any('/404', 'views/404.php');

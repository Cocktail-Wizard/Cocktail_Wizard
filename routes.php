<?php

/**
 * Routes
 *
 * Contient toutes les routes de l'application
 */
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

/*****PATCH*******/

// /api/users -> Modification d'un mot de passe
patch('/api/users', 'ressources/api/modifierMotDePasse.php');

// /api/users/image -> Modification d'une image de profil
patch('/api/users/image', 'ressources/api/modifierImageProfil.php');

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

// /api/ingredients -> Ajoute un ingrédient ou un alcool à la base de donnée
post('/api/ingredients', 'ressources/api/ajoutIng.php');

// /authentification ->Connexion d'un utilisateu utilisé pour le site web
post('/authentification', 'ressources/scripts/connexionWeb.php');

/******GET*********/

// Pour le paramètre URL page, il faut que la valeur soit sous la forme p-nb
// p : page
// nb : nombre de cocktails par page
// Exemple : page=3-15

// /api/cocktails?tri={like/date}&page=p-nb
// ->Cocktails galerie

// /api/cocktails?tri={like/date}&recherche={mot-clé}&page=3-15 -
// ->Recherche de cocktails sans filtre

// /api/cocktails?tri={like/date}&recherche={mot-clé}&user={username}&page=3-15 -
// ->Recherche de cocktails recommandés

// /api/cocktails?tri={like/date}&user={username}&page=3-15 -
// ->Liste des cocktails que l'utilisateur peut faire avec ses ingrédients. Pour galerie connectée

// /api/cocktails?user={username}&type={classiques/favoris/communaute}&page=3-15 -
// ->Liste des cocktails que l'utilisateur peut faire avec ses ingrédients. Pour mon bar

// /api/cocktails?auteur={username}&page=3-15 -
// ->Liste des cocktails qu'un utilisateur a créé

get('/api/cocktails', 'ressources/api/routageGETcocktail.php');


// /api/ingredients ->Liste des ingrédients de la base de données(Mon bar ou Création de cocktail)

// /api/ingredients?user={username} ->Liste des ingrédients de mon bar

get('/api/ingredients', '/ressources/api/getIngredients.php');


// /api/users?user={username} ->Profil utilisateur

get('/api/users', '/ressources/api/getUserInfo.php');

// /api/cocktails/commentaires?cocktail={id_coocktail} ->Liste des commentaires d'un cocktail

get('/api/cocktails/commentaires', '/ressources/api/getCocktailCommentaires.php');

/**********DELETE ************/

// /api/users/ingredients ->Suppression d'un ingrédient de mon bar
delete('/api/users/ingredients', '/ressources/api/enleverIngredientMonBar.php');

// /api/cocktails/commentaires/dislike ->Dislike d'un commentaire
// L'API retourne le nouveau nombre de likes
delete('/api/cocktails/commentaires/like', 'ressources/api/dislikeCommentaire.php');

// /api/cocktails/dislike ->Dislike d'un cocktail
// L'API retourne le nouveau nombre de like
delete('/api/cocktails/like', 'ressources/api/dislikeCocktail.php');

// /authentification ->Déconnexion d'un utilisateur
delete('/authentification', 'ressources/scripts/connexionWeb.php');

// /api/cocktails ->Suppression d'un cocktail
delete('/api/cocktails', 'ressources/api/supprimerCocktail.php');

// /api/cocktails/commentaires ->Suppression d'un commentaire
delete('/api/cocktails/commentaires', 'ressources/api/supprimerCommentaire.php');

// /api/users ->Suppression d'un profile
delete('/api/users', 'ressources/api/supprimerProfile.php');

// For GET or POST
// The 404.php which is inside the views folder will be called
// The 404.php has access to $_GET and $_POST
any('/404', 'views/404.php');

<?php

/**
 * Routage pour les requêtes GET concernant les cocktails.
 *
 * La route est déterminée par les paramètres de l'URL.
 * Si l'URL contient un paramètre 'auteur', la route renvoie les cocktails créés par cet utilisateur.
 * Si l'URL contient un paramètre 'type' et 'user', la route renvoie les cocktails recommandés pour mon bar.
 * Si l'URL contient un paramètre 'user' et 'recherche', la route renvoie les cocktails recherchés réalisables.
 * Si l'URL contient un paramètre 'user', la route renvoie les cocktails recommandés pour la galerie.
 * Si l'URL contient un paramètre 'recherche', la route renvoie les cocktails recherchés.
 * Sinon, la route renvoie les cocktails de la galerie.
 *
 * Autre paramètre possible : 'tri' pour trier les cocktails par date ou par nombre de likes.
 * 'page' pour la pagination. page=p-nb. p est le numéro de la page et nb le nombre de cocktails par page.
 * Ces paramètres sont optionnels et ont des valeurs par défaut. Si les valeurs sont incorrectes, elles seront ignorées.
 *
 * Type de requête : GET
 *
 * URL : /api/cocktails
 *
 */

if (isset($_GET['auteur'])) {

    // Vérifie si les paramètres de pagination sont valides et les récupère
    // Si les paramètres ne sont pas valides, ils prendront des valeurs par défaut
    if (isset($_GET['page']) && preg_match('/^[0-9]+-[0-9]+$/', $_GET['page'])) {
        $pagination = explode('-', $_GET['page']);
        $page = (int) $pagination[0];
        $nbCocktailPage = (int) $pagination[1];
    } else {
        $page = 1;
        $nbCocktailPage = 10;
    }

    $username = trim($_GET['auteur']);

    require_once __DIR__ . '/getUserCocktails.php';
} else if (isset($_GET['type']) && isset($_GET['user'])) {

    $type = trim($_GET['type']);
    $username = trim($_GET['user']);

    if (isset($_GET['page']) && preg_match('/^[0-9]+-[0-9]+$/', $_GET['page'])) {
        $pagination = explode('-', $_GET['page']);
        $page = (int) $pagination[0];
        $nbCocktailPage = (int) $pagination[1];
    } else {
        $page = 1;
        $nbCocktailPage = 10;
    }

    require_once __DIR__ . '/getUserRecommandations.php';
} else if (isset($_GET['user']) && isset($_GET['recherche'])) {

    $username = trim($_GET['user']);
    $recherche = trim($_GET['recherche']);

    if (isset($_GET['page']) && preg_match('/^[0-9]+-[0-9]+$/', $_GET['page'])) {
        $pagination = explode('-', $_GET['page']);
        $page = (int) $pagination[0];
        $nbCocktailPage = (int) $pagination[1];
    } else {
        $page = 1;
        $nbCocktailPage = 10;
    }

    // Vérifie si le paramètre de tri est valide et le récupère.
    // Si le paramètres n'est pas valide, il prend une valeur par défaut
    if (isset($_GET['tri']) && ($_GET['tri'] == 'like' || $_GET['tri'] == 'date')) {
        $tri = trim($_GET['tri']);
    } else {
        $tri = 'like';
    }

    require_once __DIR__ . '/rechercheUserRecommandations.php';
} else if (isset($_GET['user'])) {

    $username = trim($_GET['user']);

    if (isset($_GET['page']) && preg_match('/^[0-9]+-[0-9]+$/', $_GET['page'])) {
        $pagination = explode('-', $_GET['page']);
        $page = (int) $pagination[0];
        $nbCocktailPage = (int) $pagination[1];
    } else {
        $page = 1;
        $nbCocktailPage = 10;
    }

    if (isset($_GET['tri']) && ($_GET['tri'] == 'like' || $_GET['tri'] == 'date')) {
        $tri = trim($_GET['tri']);
    } else {
        $tri = 'like';
    }

    require_once __DIR__ . '/getUserRecommandations.php';
} else if (isset($_GET['recherche'])) {

    $recherche = trim($_GET['recherche']);

    if (isset($_GET['page']) && preg_match('/^[0-9]+-[0-9]+$/', $_GET['page'])) {
        $pagination = explode('-', $_GET['page']);
        $page = (int) $pagination[0];
        $nbCocktailPage = (int) $pagination[1];
    } else {
        $page = 1;
        $nbCocktailPage = 10;
    }

    if (isset($_GET['tri']) && ($_GET['tri'] == 'like' || $_GET['tri'] == 'date')) {
        $tri = trim($_GET['tri']);
    } else {
        $tri = 'like';
    }

    require_once __DIR__ . '/rechercheCocktail.php';
} else {

    if (isset($_GET['page']) && preg_match('/^[0-9]+-[0-9]+$/', $_GET['page'])) {
        $pagination = explode('-', $_GET['page']);
        $page = (int) $pagination[0];
        $nbCocktailPage = (int) $pagination[1];
    } else {
        $page = 1;
        $nbCocktailPage = 10;
    }

    if (isset($_GET['tri']) && ($_GET['tri'] == 'like' || $_GET['tri'] == 'date')) {
        $tri = trim($_GET['tri']);
    } else {
        $tri = 'like';
    }

    require_once __DIR__ . '/getCocktails.php';
}

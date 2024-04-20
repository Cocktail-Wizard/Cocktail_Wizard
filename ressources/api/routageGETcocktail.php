<?php
if(isset($_GET['auteur'])) {

    if(isset($_GET['page']) && preg_match('/^[0-9]+-[0-9]+$/', $_GET['page'])) {
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

} else if(isset($_GET['user']) && isset($_GET['recherche'])) {

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

    if(isset($_GET['tri']) && ($_GET['tri'] == 'like' || $_GET['tri'] == 'date')) {
        $tri = trim($_GET['tri']);
    } else {
        $tri = 'like';
    }

    require_once __DIR__ . '/rechercheUserRecommandations.php';

} else if(isset($_GET['user'])) {

    $username = trim($_GET['user']);

    if (isset($_GET['page']) && preg_match('/^[0-9]+-[0-9]+$/', $_GET['page'])) {
        $pagination = explode('-', $_GET['page']);
        $page = (int) $pagination[0];
        $nbCocktailPage = (int) $pagination[1];
    } else {
        $page = 1;
        $nbCocktailPage = 10;
    }

    if(isset($_GET['tri']) && ($_GET['tri'] == 'like' || $_GET['tri'] == 'date')) {
        $tri = trim($_GET['tri']);
    } else {
        $tri = 'like';
    }

    require_once __DIR__ . '/getUserRecommandations.php';

}  else if(isset($_GET['recherche'])) {

    $recherche = trim($_GET['recherche']);

    if (isset($_GET['page']) && preg_match('/^[0-9]+-[0-9]+$/', $_GET['page'])) {
        $pagination = explode('-', $_GET['page']);
        $page = (int) $pagination[0];
        $nbCocktailPage = (int) $pagination[1];
    } else {
        $page = 1;
        $nbCocktailPage = 10;
    }

    if(isset($_GET['tri']) && ($_GET['tri'] == 'like' || $_GET['tri'] == 'date')) {
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

    if(isset($_GET['tri']) && ($_GET['tri'] == 'like' || $_GET['tri'] == 'date')) {
        $tri = trim($_GET['tri']);
    } else {
        $tri = 'like';
    }

    require_once __DIR__ . '/getCocktails.php';
}

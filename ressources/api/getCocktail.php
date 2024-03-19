<?php
    // Vérifier si l'ajout de header est nécessaire
    require_once __DIR__ . '/ressources/api/config.php';
    require_once __DIR__ . '/ressources/classephp/Cocktail_Classe.php';
    require_once __DIR__ . '/ressources/classephp/IngredientCocktail_Classe.php';
    require_once __DIR__ . '/ressources/classephp/IngredientAlcool_Classe.php';
    require_once __DIR__ . '/ressources/classephp/Commentaire_Classe.php';

    //Ajouter gestion du nombre de cocktail à renvoyer

    //Ajouter du code pour la gestion des erreurs

    //Paramètre $_GET['dest'] représente l'endroit où les cocktails sont afficher
    switch($_GET['dest']){
        case 'GalerieNonFiltrer':
            $triage =  ($_GET['triage']);
            getCocktailGalerieNonfiltrer($triage);
            break;
        case 'GalerieFiltrer':
            $user_Id = $_GET['userId'];
            $triage = $_GET['triage'];
            getCocktailGalerieFiltrer($user_Id,$triage);
            break;
        case 'MonBarClassique':
            $user_Id = $_GET['userId'];
            getCocktailClassiqueMonBar($user_Id);
            break;
        case 'MonBarFavorie':
            $userId = $_GET['userId'];
            getCocktailFavorieMonBar($user_Id);
            break;
        case 'MonBarCommunautaire':
            $user_Id = $_GET['userId'];
            getCocktailCommunataireMonBar($user_Id);
            break;
        case 'MesCocktailsProfil':
            $user_Id = $_GET['userId'];
            getMesCocktailsProfil($user_Id);
            break;
        default:
            http_response_code(400);
            echo json_encode("Erreur: Paramètre invalide.");
            break;
    }
    function getCocktailGalerieNonfiltrer($triage){

        $conn = connexionBD();

        if($conn == null){
            http_response_code(500);
            echo json_encode("Erreur de connexion à la base de données.");
            exit();
        }

        $triage_s = mysqli_real_escape_string($conn, $triage);

        $id_cocktail = [];
        $cocktails = [];

        $requete_preparee = $conn->prepare("CALL GetCocktailGalerieNonFiltrer(?)");
        $requete_preparee->bind_param("s", $triage_s);
        $requete_preparee->execute();
        $resultat = $requete_preparee->get_result();

        if($resultat->num_rows > 0){
            while($row = $resultat->fetch_assoc()){
                $id_cocktail[] = $row['id_cocktail'];
            }
        }

        $requete_preparee->close();

        foreach($id_cocktail as $id) {

            $cocktails[] = remplirCocktail($id, $conn);

        }

        echo json_encode($cocktails);

        $conn->close();
    }

    function getCocktailGalerieFiltrer($userId,$triage){

        $conn = connexionBD();


        if($conn == null){
            http_response_code(500);
            echo json_encode("Erreur de connexion à la base de données.");
            exit();
        }

        $userId_s = mysqli_real_escape_string($conn, $userId);
        $triage_s = mysqli_real_escape_string($conn, $triage);

        $id_cocktail = [];
        $cocktails = [];

        $requete_preparee = $conn->prepare("CALL GetCocktailGalerieFiltrer(?,?)");
        $requete_preparee->bind_param("is", $userId_s,$triage_s);
        $requete_preparee->execute();
        $resultat = $requete_preparee->get_result();

        if($resultat->num_rows > 0){
            while($row = $resultat->fetch_assoc()){
                $id_cocktail[] = $row['id_cocktail'];
            }
        }

        $requete_preparee->close();

        foreach($id_cocktail as $id) {

            $cocktails[] = remplirCocktail($id, $conn);

        }

        echo json_encode($cocktails);

        $conn->close();

    }

    function getCocktailClassiqueMonBar($userId){

        $conn = connexionBD();

        if($conn == null){
            http_response_code(500);
            echo json_encode("Erreur de connexion à la base de données.");
            exit();
        }

        $userId_s = mysqli_real_escape_string($conn, $userId);

        $id_cocktail = [];
        $cocktails = [];

        $requete_preparee = $conn->prepare("CALL GetCocktailPossibleClassique(?)");
        $requete_preparee->bind_param("i",$userId_s);
        $requete_preparee->execute();
        $resultat = $requete_preparee->get_result();

        if($resultat->num_rows > 0){
            while($row = $resultat->fetch_assoc()){
                $id_cocktail[] = $row['id_cocktail'];
            }
        }

        $requete_preparee->close();

        foreach($id_cocktail as $id) {

            $cocktails[] = remplirCocktail($id, $conn);

        }

        echo json_encode($cocktails);

        $conn->close();
    }

    function getCocktailFavorieMonBar($userId){
        $conn = connexionBD();

        if($conn == null){
            http_response_code(500);
            echo json_encode("Erreur de connexion à la base de données.");
            exit();
        }

        $userId_s = mysqli_real_escape_string($conn, $userId);

        $id_cocktail = [];
        $cocktails = [];

        $requete_preparee = $conn->prepare("CALL GetListeCocktailPossibleFavorie(?)");
        $requete_preparee->bind_param("i",$userId_s);
        $requete_preparee->execute();
        $resultat = $requete_preparee->get_result();

        if($resultat->num_rows > 0){
            while($row = $resultat->fetch_assoc()){
                $id_cocktail[] = $row['id_cocktail'];
            }
        }

        $requete_preparee->close();

        foreach($id_cocktail as $id) {

            $cocktails[] = remplirCocktail($id, $conn);
        }


        echo json_encode($cocktails);

        $conn->close();

    }

    function getCocktailCommunataireMonBar($userId){

        $conn = connexionBD();

        if($conn == null){
            http_response_code(500);
            echo json_encode("Erreur de connexion à la base de données.");
            exit();
        }

        $userId_s = mysqli_real_escape_string($conn, $userId);

        $id_cocktail = [];
        $cocktails = [];

        $requete_preparee = $conn->prepare("CALL GetCocktailsPossibleCommunautaire(?)");
        $requete_preparee->bind_param("i",$userId_s);
        $requete_preparee->execute();
        $resultat = $requete_preparee->get_result();

        if($resultat->num_rows > 0){
            while($row = $resultat->fetch_assoc()){
                $id_cocktail[] = $row['id_cocktail'];
            }
        }

        $requete_preparee->close();

        foreach($id_cocktail as $id) {

            $cocktails[] = remplirCocktail($id, $conn);
        }


        echo json_encode($cocktails);

        $conn->close();
    }

    function getMesCocktailsProfil($userId){
        $conn = connexionBD();

        if($conn == null){
            http_response_code(500);
            echo json_encode("Erreur de connexion à la base de données.");
            exit();
        }

        $userId_s = mysqli_real_escape_string($conn, $userId);

        $id_cocktail = [];
        $cocktails = [];

        $requete_preparee = $conn->prepare("CALL GetMesCocktails(?)");
        $requete_preparee->bind_param("i",$userId_s);
        $requete_preparee->execute();
        $resultat = $requete_preparee->get_result();

        if($resultat->num_rows > 0){
            while($row = $resultat->fetch_assoc()){
                $id_cocktail[] = $row['id_cocktail'];
            }
        }

        $requete_preparee->close();

        foreach($id_cocktail as $id) {

            $cocktails[] = remplirCocktail($id);
        }


        echo json_encode($cocktails);

        $conn->close();
    }


    function remplirCocktail($cocktailId, $conn){

        $requete_preparee = $conn->prepare("CALL GetInfoCocktailComplet(?)");
        $requete_preparee->bind_param("i", $cocktailId);
        $requete_preparee->execute();
        $resultat = $requete_preparee->get_result();

        if($resultat->num_rows > 0) {
            $row = $resultat->fetch_assoc();

            $cocktail = new Cocktail($row['nom'], $row['desc_cocktail'], $row['preparation'],
            $row['imgCocktail'], $row['imgAuteur'], $row['auteur'], $row['date_publication'],
            $row['nb_like'], $row['alcool_principale'], $row['profil_saveur'], $row['type_verre']);
        }

        $requete_preparee->close();

        $requete_preparee = $conn->prepare("CALL GetListeIngredientsCocktail(?)");
        $requete_preparee->bind_param("i", $cocktailId);
        $requete_preparee->execute();
        $resultat = $requete_preparee->get_result();

        if($resultat->num_rows > 0){
            while($row = $resultat->fetch_assoc()){
                $ingredient = new IngredientCocktail($row['quantite'], $row['unite'], $row['nom']);
                $cocktail->ajouterIngredient($ingredient);
            }
        }

        $requete_preparee->close();

        $requete_preparee = $conn->prepare("CALL GetCommentairesCocktail(?, 'like')");
        $requete_preparee->bind_param("i", $cocktailId);
        $requete_preparee->execute();
        $resultat = $requete_preparee->get_result();

        if($resultat->num_rows > 0){
            while($row = $resultat->fetch_assoc()){
                $commentaire = new Commentaire($row['img'], $row['nom'], $row['date_publication'], $row['contenu'], $row['nb_like']);
                $cocktail->ajouterCommentaire($commentaire);
            }
        }

        $requete_preparee->close();

        return $cocktail;
    }
?>

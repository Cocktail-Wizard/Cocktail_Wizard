<?php
    // Vérifier si l'ajout de header est nécessaire
    require_once __DIR__ . '/ressources/api/config.php';
    require_once __DIR__ . '/ressources/classephp/Cocktail_Classe.php';
    require_once __DIR__ . '/ressources/classephp/IngredientCocktail_Classe.php';
    require_once __DIR__ . '/ressources/classephp/IngredientAlcool_Classe.php';
    require_once __DIR__ . '/ressources/classephp/Commentaire_Classe.php';

    //Ajouter gestion du nombre de cocktail à renvoyer

    //Paramètre $_GET['dest'] représente l'endroit où les cocktails sont afficher
    switch($_GET['dest']){
        case 'GalerieNonFiltrer':
            $triage = $_GET['triage'];
            getCocktailGalerieNonfiltrer($triage);
            break;
        case 'GalerieFiltrer':
            $userId = $_GET['userId'];
            $triage = $_GET['triage'];
            getCocktailGalerieFiltrer($userId,$triage);
            break;
        case 'MonBarClassique':
            $userId = $_GET['userId'];
            getCocktailClassiqueMonBar($userId);
            break;
        case 'MonBarFavorie':
            $userId = $_GET['userId'];
            getCocktailFavorieMonBar($userId);
            break;
        case 'MonBarCommunautaire':
            getCocktailCommunataireMonBar($userId);
            break;
        case 'MesCocktailsProfil':
            getMesCocktailsProfil($userId);
            break;
        default:
            echo "Erreur, destination non reconnue.";
            break;
    }
    function getCocktailGalerieNonfiltrer($triage){
        $conn = connexionBD();

        if($conn == null){
            http_response_code(500);
            echo json_encode("Erreur de connexion à la base de données.");
            exit();
        }

        $id_cocktail = [];
        $cocktails = [];

        $requete_preparee = $conn->prepare("CALL GetCocktailGalerieNonFiltrer(?)");
        $requete_preparee->bind_param("s", $triage);
        $requete_preparee->execute();

        if($resultat->num_rows > 0){
            while($row = $resultat->fetch_assoc()){
                $id_cocktail[] = $row['id_cocktail'];
            }
        }

        $requete_preparee->close();

        foreach($id_cocktail as $id) {
            $requete_preparee = $conn->prepare("CALL GetInfoCocktailComplet(?)");
            $requete_preparee->bind_param("i", $id);
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
            $requete_preparee->bind_param("i", $id);
            $requete_preparee->execute();
            $resultat = $requete_preparee->get_result();

            if($resultat->num_rows > 0){
                while($row = $resultat->fetch_assoc()){
                    $ingredient = new IngredientCocktail($row['quantite'], $row['unite'], $row['nom']);
                    $cocktail->ajouterIngredient($ingredient);
                }
            }

            $requete_preparee->close();

            $requete_preparee = $conn->prepare("CALL GetCommentairesCocktail(?, like)");
            $requete_preparee->bind_param("i", $id);
            $requete_preparee->execute();
            $resultat = $requete_preparee->get_result();

            if($resultat->num_rows > 0){
                while($row = $resultat->fetch_assoc()){
                    $commentaire = new Commentaire($row['img'], $row['nom'], $row['date_publication'], $row['contenu'], $row['nb_like']);
                    $cocktail->ajouterCommentaire($commentaire);
                }
            }

            $requete_preparee->close();

            $cocktails[] = $cocktail;

        }

        echo json_encode($cocktails);

        $conn->close();
    }

    function getCocktailGalerieFiltrer($userId,$triage){

    }

    function getCocktailClassiqueMonBar($userId){

    }

    function getCocktailFavorieMonBar($userId){

    }

    function getCocktailCommunataireMonBar($userId){

    }

    function getMesCocktailsProfil($userId){

    }
?>

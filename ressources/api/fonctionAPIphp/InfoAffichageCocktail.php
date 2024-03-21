<?php
/*
 * Fonction InfoAffichageCocktail
 *
 * Permet de remplire un objet Cocktail avec les informations nécessaires pour l'affichage
 * à partir de son id_cocktail et de la connexion à la base de données.
 *
 */
require_once ("../classephp/Cocktail_Classe.php");
require_once("../classephp/IngredientCocktail_Classe.php");
require_once("../classephp/Commentaire_Classe.php");

function InfoAffichageCocktail($id_cocktail, $conn) {

    $requete_preparee = $conn->prepare("CALL GetInfoCocktailComplet(?)");
    $requete_preparee->bind_param("i", $id_cocktail);
    $requete_preparee->execute();
    $resultat = $requete_preparee->get_result();

    if($resultat->num_rows > 0) {
        $row = $resultat->fetch_assoc();

        $cocktail = new Cocktail($row['id_cocktail'],$row['nom'], $row['desc_cocktail'], $row['preparation'],
        $row['imgCocktail'], $row['imgAuteur'], $row['auteur'], $row['date_publication'],
        $row['nb_like'], $row['alcool_principale'], $row['profil_saveur'], $row['type_verre']);
    }

    $requete_preparee->close();

    $requete_preparee = $conn->prepare("CALL GetListeIngredientsCocktail(?)");
    $requete_preparee->bind_param("i", $id_cocktail);
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
    $requete_preparee->bind_param("i", $id_cocktail);
    $requete_preparee->execute();
    $resultat = $requete_preparee->get_result();

    if($resultat->num_rows > 0){
        while($row = $resultat->fetch_assoc()){
            $commentaire = new Commentaire($row['id_commentaire'],$row['img'], $row['nom'], $row['date_commentaire'], $row['contenu'], $row['nb_like']);
            $cocktail->ajouterCommentaire($commentaire);
        }
    }

    $requete_preparee->close();

    return $cocktail;

}



?>

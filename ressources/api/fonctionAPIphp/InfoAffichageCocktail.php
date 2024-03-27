<?php

/**
 * Fonction InfoAffichageCocktail
 *
 * Permet de remplire un objet Cocktail avec les informations nécessaires pour l'affichage
 * à partir de son id_cocktail et de la connexion à la base de données.
 *
 * @param int $id_cocktail L'id du cocktail dont on veut les informations
 * @param mysqli $conn La connexion à la base de données
 *
 * @return Cocktail L'objet Cocktail rempli avec les informations du cocktail
 *
 * @author Yani Amellal
 *
 * @version 1.0
 */

// Importation des classes nécessaires
require_once(__DIR__ . "/../../classephp/Cocktail_Classe.php");
require_once(__DIR__ . "/../../classephp/IngredientCocktail_Classe.php");
require_once(__DIR__ . "/../../classephp/Commentaire_Classe.php");

function InfoAffichageCocktail($id_cocktail, $conn)
{
    // Envoie une requête à la base de données pour obtenir les informations du cocktail à partir de son id
    $requete_preparee = $conn->prepare("CALL GetInfoCocktailComplet(?)");
    $requete_preparee->bind_param("i", $id_cocktail);
    $requete_preparee->execute();
    $resultat = $requete_preparee->get_result();
    $requete_preparee->close();
    // Si le cocktail est trouvé, on crée un objet Cocktail avec les informations obtenues
    if ($resultat->num_rows > 0) {
        $row = $resultat->fetch_assoc();

        $cocktail = new Cocktail(
            $row['id_cocktail'],
            $row['nom'],
            $row['desc_cocktail'],
            $row['preparation'],
            $row['imgCocktail'],
            $row['imgAuteur'],
            $row['auteur'],
            $row['date_publication'],
            $row['nb_like'],
            $row['alcool_principale'],
            $row['profil_saveur'],
            $row['type_verre']
        );
    } else {
        http_response_code(404);
        echo json_encode("Aucun cocktail n'a été trouvé avec cet id.");
        exit();
    }

    $requete_preparee->close();

    // Envoie une requête à la base de données pour obtenir les ingrédients du cocktail à partir de son id
    $requete_preparee = $conn->prepare("CALL GetListeIngredientsCocktail(?)");
    $requete_preparee->bind_param("i", $id_cocktail);
    $requete_preparee->execute();
    $resultat = $requete_preparee->get_result();

    // Ajoute les ingrédients obtenus à la liste des ingrédients du cocktail
    if ($resultat->num_rows > 0) {
        while ($row = $resultat->fetch_assoc()) {
            $ingredient = new IngredientCocktail($row['quantite'], $row['unite'], $row['nom']);
            $cocktail->ajouterIngredient($ingredient);
        }
    } else {
        http_response_code(404);
        echo json_encode("Aucun ingrédient n'a été trouvé pour ce cocktail.");
        exit();
    }

    $requete_preparee->close();

    return $cocktail; // Retourne l'objet Cocktail
}

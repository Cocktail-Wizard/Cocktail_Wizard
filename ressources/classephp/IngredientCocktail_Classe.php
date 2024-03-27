<?php
/*
 * Classe IngredientCocktail
 *
 * Permet de créer un objet IngredientCocktail qui contient les informations utiliser
 * pour l'affichage d'un ingrédient d'un cocktail.
 *
 * Auteur : Yani Amellal
 * Date : 18 mars 2023
 */

class IngredientCocktail implements JsonSerializable
{

    private $quantite;
    private $unite;
    private $ingredient; // Nom de l'ingrédient(peut être un alcool ou un autre ingrédient)

    public function __construct($quantite, $unite, $ingredient)
    {
        $this->quantite = $quantite;
        $this->unite = $unite;
        $this->ingredient = $ingredient;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}

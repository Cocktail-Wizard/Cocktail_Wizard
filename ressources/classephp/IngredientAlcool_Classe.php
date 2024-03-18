<?php
/*
* Classe IngredientAlcool
*
* Permet de créer un objet IngredientAlcool qui contient les informations utiliser
* pour l'affichage d'un ingrédient alcoolisé. Hérite de IngredientCocktail.
*
* Auteur : Yani Amellal
* Date : 18 mars 2023
*
*/
Class IngredientAlcool extends IngredientCocktail{
    // Information sur l'alcool à afficher dans la bulle d'information
    // lorsque l'utilisateur survol l'icone ? à côté de l'ingrédient
    private $information;
    // Lien vers la SAQ pour l'achat de l'alcool lorsque l'utilisateur clique sur l'icone ?
    private $lien_saq;

    public function __construct($quantite, $unite, $ingredient, $information, $lien_saq) {
        parent::__construct($quantite, $unite, $ingredient);
        $this->information = $information;
        $this->lien_saq = $lien_saq;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }
}
?>

<?php
Class IngredientAlcool extends IngredientCocktail{

    private $information;
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

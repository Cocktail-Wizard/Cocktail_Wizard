/*
 * Classe Cocktail
 *
 * Permet de créer un objet Cocktail qui contient les informations utiliser
 * pour l'affichage d'un cocktail.
 *
 * Auteur : Yani Amellal
 * Date : 18 mars 2023
 *
 */
<?php
class Cocktail implements JsonSerializable {

    private $id_cocktail;
    private $nom;
    private $desc;
    private $preparation;
    private $img;
    private $auteur;
    private $date;
    private $nb_like;
    private $alcool_principale;
    private $profil_saveur;
    private $type_verre;

    private $commentaires = [];
    private $ingredients_cocktail = [];

    public function _construct($id_cocktail, $nom, $desc, $preparation, $img, $auteur, $date,
     $nb_like, $alcool_principale, $profil_saveur, $type_verre) {
        $this->id_cocktail = $id_cocktail;
        $this->nom = $nom;
        $this->desc = $desc;
        $this->preparation = $preparation;
        $this->img = $img;
        $this->auteur = $auteur;
        $this->date = $date;
        $this->nb_like = $nb_like;
        $this->alcool_principale = $alcool_principale;
        $this->profil_saveur = $profil_saveur;
        $this->type_verre = $type_verre;
    }

    public function ajouterCommentaire($commentaire) {
        $this->commentaires[] = $commentaire;
    }

    public function ajouterIngredient($ingredient) {
        $this->ingredients_cocktail[] = $ingredient;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }
}

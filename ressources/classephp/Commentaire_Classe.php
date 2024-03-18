<?php
/*
 * Classe Commentaire
 *
 * Permet de créer un objet Commentaire qui contient les informations utiliser
 * pour l'affichage d'un commentaire.
 *
 * Auteur : Yani Amellal
 * Date : 18 mars 2023
 *
 */
class Commentaire implements JsonSerializable {

    private $id_commentaire;
    private $auteur;
    private $date;
    private $contenu;
    private $nb_like;
    // Permet de savoir si l'utilisateur a liké le commentaire quand connecté
    // Valeur: null si l'utilisateur n'est pas connecté, true si l'utilisateur a liké, false sinon
    private $liked;

    public function __construct($id_commentaire, $auteur, $date, $contenu, $nb_like) {
        $this->id_commentaire = $id_commentaire;
        $this->auteur = $auteur;
        $this->date = $date;
        $this->contenu = $contenu;
        $this->nb_like = $nb_like;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }
}
?>

<?php

/**
 * Classe Commentaire
 *
 * Permet de créer un objet Commentaire qui contient les informations utiliser
 * pour l'affichage d'un commentaire.
 *
 * @version 1.0
 *
 * @author Yani Amellal
 */

class Commentaire implements JsonSerializable
{
    private $id_commentaire;
    private $img_auteur;
    private $auteur;
    private $date;
    private $contenu;
    private $nb_like;
    // Permet de savoir si l'utilisateur a liké le commentaire quand connecté
    // Valeur: null si l'utilisateur n'est pas connecté, true si l'utilisateur a liké, false sinon
    private $liked;

    public function __construct($id_commentaire, $img_auteur, $auteur, $date, $contenu, $nb_like)
    {
        $this->id_commentaire = $id_commentaire;
        $this->img_auteur = $img_auteur;
        $this->auteur = $auteur;
        $dateTemps = new DateTime($date);
        $this->date = $dateTemps->format('d-m-Y');
        $this->contenu = $contenu;
        $this->nb_like = $nb_like;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}

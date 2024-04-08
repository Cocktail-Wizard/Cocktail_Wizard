<?php

/**
 * Classe Utilisateur
 *
 * Permet de créer un objet Utilisateur qui contient les informations utiliser
 * pour la gestion d'un utilisateur dans la section mon profil. La classe représente
 * un utilisateur du site web connecté.
 *
 * @version 1.0
 *
 * @author Yani Amellal
 */

class Utilisateur implements JsonSerializable
{
    //private $id_utilisateur;
    private $nom;
    private $courriel;
    // Privilege de l'utilisateur: true si l'utilisateur est admin, false sinon
    //private $privilege;
    private $img_profil;
    private $nb_cocktail_cree;
    private $nb_cocktail_favoris;
    private $nb_commentaire;

    public function __construct($nom, $courriel, $img_profil, $nb_cocktail_cree, $nb_cocktail_favoris, $nb_commentaire)
    {
        //$this->id_utilisateur = $id_utilisateur;
        $this->nom = $nom;
        $this->courriel = $courriel;
        // $this->privilege = $privilege;
        $this->img_profil = $img_profil;
        $this->nb_cocktail_cree = $nb_cocktail_cree;
        $this->nb_cocktail_favoris = $nb_cocktail_favoris;
        $this->nb_commentaire = $nb_commentaire;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}

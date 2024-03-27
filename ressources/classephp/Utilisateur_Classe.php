<?php

namespace App\Classe;

use JsonSerializable;

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

    public function __construct($nom, $courriel, $img_profil)
    {
        //$this->id_utilisateur = $id_utilisateur;
        $this->nom = $nom;
        $this->courriel = $courriel;
        // $this->privilege = $privilege;
        $this->img_profil = $img_profil;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}

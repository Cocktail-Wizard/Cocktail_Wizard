-- ============================================================
-- Auteurs : Yani Amellal, Léonard Marcoux, Pablo Hamel-Corôa,
--           Maxime Dmitriev et Vianney Veremme
-- Date de création : 03-03-2024
-- Description :
--  Script de création des procédures de la base donnée reliée
--  au site web cocktail wizard
-- Procédures :
--
-- ============================================================

-- Ajouter procédure qui permet de like et renvoyer le nouveau
-- nombre de like

-- Manque logique de gestion des images

-- Le session_id du siteweb doit être le id_utilisateur

-- À faire ajout d'indexe pour les order by qui renvoit bcp de donnees

-- À faire, diminuer la quantité de procédures en envoyant plus d'informations en une seule fois
-- qui seront stocker dans des objets php

-- À faire, déterminer la quantité de cocktail renvoyer à la fois

-- Affiche les procédures
SHOW PROCEDURE STATUS;

DELIMITER //

--Création de la procédure InscriptionUtilisateur
-- Permet d'inscrire un utilisateur
-- Utiliser pour l'inscription
-- var_date_naissance: 'YYYY-MM-DD'
DROP PROCEDURE IF EXISTS InscriptionUtilisateur;

CREATE PROCEDURE InscriptionUtilisateur(IN var_nom
VARCHAR(100), IN var_courriel VARCHAR(255), IN var_mdp_hashed
VARCHAR(255), IN var_date_naissance DATE)
BEGIN
	INSERT INTO
	    Utilisateur (
	        nom, courriel, mdp_hashed, date_naiss
	    )
	VALUES (
	        var_nom, var_courriel, var_mdp_hashed, var_date_naissance
	    );
END
//

--Création de la procédure ConnexionUtilisateur
-- Renvoie le mot_de_passe_hashé afin de vérifier si le mot de passe est correct
-- Utiliser pour la connexion
DROP PROCEDURE IF EXISTS ConnexionUtilisateur;

CREATE PROCEDURE ConnexionUtilisateur(IN var_courriel
VARCHAR(255))
BEGIN
	SELECT mdp_hashed FROM Utilisateur WHERE courriel = var_courriel;
END
//

--Création de la procédure GetIduser
-- Renvoie le id_utilisateur
-- Utiliser pour convertir un username en id
DROP PROCEDURE IF EXISTS GetIdUser;

CREATE PROCEDURE GetIdUser(IN username VARCHAR(255)
)
BEGIN
	SELECT id_utilisateur FROM Utilisateur WHERE nom = username;
END
//

--Création de la procédure AjoutIngredient
-- Permet d'ajouter un ingrédient à un utilisateur
-- Utiliser pour ajouter un ingrédient dans mon bar
DROP PROCEDURE IF EXISTS AjoutIngredient;

CREATE PROCEDURE AjoutIngredient(IN var_id_utilisateur
INT, IN var_nom_ingredient VARCHAR(255), IN var_type_ingredient
VARCHAR(50))
BEGIN
	IF var_type_ingredient = 'alcool' THEN
	INSERT INTO
	    Alcool_Utilisateur (id_utilisateur, id_alcool)
	SELECT var_id_utilisateur, id_alcool
	FROM Alcool
	WHERE
	    nom = var_nom_ingredient;
	ELSE
	INSERT INTO
	    Ingredient_Utilisateur (id_utilisateur, id_ingredient)
	SELECT
	    var_id_utilisateur,
	    id_ingredient
	FROM Ingredient
	WHERE
	    nom = var_nom_ingredient;
END
	IF;
	CALL GetMesIngredients (var_id_utilisateur);
END
//

--Création de la procédure RetraitIngredient
-- Permet d'enlerver un ingrédient à un utilisateur
-- Utiliser pour enlever un ingrédient dans mon bar
DROP PROCEDURE IF EXISTS RetraitIngredient;

CREATE PROCEDURE RetraitIngredient(IN var_id_utilisateur
INT, IN var_nom_ingredient VARCHAR(255), IN var_type_ingredient
VARCHAR(50))
BEGIN
	IF var_type_ingredient = 'alcool' THEN
	DELETE FROM Alcool_Utilisateur
	WHERE
	    id_utilisateur = var_id_utilisateur
	    AND id_alcool IN (
	        SELECT id_alcool
	        FROM Alcool
	        WHERE
	            nom = var_nom_ingredient
	    );
	ELSE
	DELETE FROM Ingredient_Utilisateur
	WHERE
	    id_utilisateur = var_id_utilisateur
	    AND id_ingredient IN (
	        SELECT id_ingredient
	        FROM Ingredient
	        WHERE
	            nom = var_nom_ingredient
	    );
END
	IF;
	CALL GetMesIngredients (var_id_utilisateur);
END
//

--Création de la procédure LikeCocktail
-- Permet de liker un cocktail et renvoyer le nouveau nombre de like
-- du cocktail
-- Utiliser pour liker un cocktail
DROP PROCEDURE IF EXISTS LikeCocktail;

CREATE PROCEDURE LikeCocktail(IN var_id_cocktail INT
, IN var_id_utilisateur INT)
BEGIN
	INSERT INTO
	    cocktail_liked (id_cocktail, id_utilisateur)
	VALUES (
	        var_id_cocktail, var_id_utilisateur
	    );
	SELECT C.nb_like
	FROM Cocktail C
	WHERE
	    id_cocktail = var_id_cocktail;
END
//

--Création de la procédure DislikeCocktail
-- Permet de disliker un cocktail et renvoyer le nouveau nombre de like
-- du cocktail
-- Utiliser pour disliker un cocktail
DROP PROCEDURE IF EXISTS DislikeCocktail;

CREATE PROCEDURE DislikeCocktail(IN var_id_cocktail
INT, IN var_id_utilisateur INT)
BEGIN
	DELETE FROM cocktail_liked
	WHERE
	    id_cocktail = var_id_cocktail
	    AND id_utilisateur = var_id_utilisateur;
	SELECT C.nb_like
	FROM Cocktail C
	WHERE
	    id_cocktail = var_id_cocktail;
END
//

--Création de la procédure LikeCommentaire
-- Permet de liker un commentaire et renvoyer le nouveau nombre de like
-- du commentaire
-- Utiliser pour liker un commentaire
DROP PROCEDURE IF EXISTS LikeCommentaire;

CREATE PROCEDURE LikeCommentaire(IN var_id_commentaire
INT, IN var_id_utilisateur INT)
BEGIN
	INSERT INTO
	    commentaire_liked (
	        id_commentaire, id_utilisateur
	    )
	VALUES (
	        var_id_commentaire, var_id_utilisateur
	    );
	SELECT C.nb_like
	FROM Commentaire C
	WHERE
	    id_commentaire = var_id_commentaire;
END
//

--Création de la procédure DislikeCommentaire
-- Permet de disliker un commentaire et renvoyer le nouveau nombre de like
-- du commentaire
-- Utiliser pour disliker un commentaire
DROP PROCEDURE IF EXISTS DislikeCommentaire;

CREATE PROCEDURE DislikeCommentaire(IN var_id_commentaire
INT, IN var_id_utilisateur INT)
BEGIN
	DELETE FROM commentaire_liked
	WHERE
	    id_commentaire = var_id_commentaire
	    AND id_utilisateur = var_id_utilisateur;
	SELECT C.nb_like
	FROM Commentaire C
	WHERE
	    id_commentaire = var_id_commentaire;
END
//

----------------- Création d'un cocktail -----------------

--Création de la procédure CreerCocktail
-- Permet de créer un cocktail
-- Utiliser pour la création de cocktail. Le id_cocktail est retouner afin de
-- de pouvoir utiliser lors de l'ajout des ingrédients cocktails.
DROP PROCEDURE IF EXISTS CreerCocktail;

CREATE PROCEDURE CreerCocktail(IN var_nom VARCHAR(255
), IN var_desc_cocktail TEXT, IN var_preparation TEXT
, IN var_type_verre VARCHAR(50), IN var_profil_saveur
VARCHAR(50), IN var_id_utilisateur INT, OUT id_cocktail INT
)
BEGIN
	INSERT INTO
	    Cocktail (
	        nom, desc_cocktail, preparation, type_verre, profil_saveur, id_utilisateur
	    )
	VALUES (
	        var_nom, var_desc_cocktail, var_preparation, var_type_verre, var_profil_saveur, var_id_utilisateur
	    );
	SET id_cocktail = LAST_INSERT_ID();
END
//

--Création de la procédure AjouterIngredientCocktail
-- Permet d'ajouter un ingrédient à un cocktail
-- Utiliser pour la création de cocktail
-- Query à faire dans le code php afin de pouvoir ajouter plusieurs ingrédients
-- à la fois

--Création de la procédure GetCocktailGalerieNonFiltrer
-- Permet de voir tous les cocktails de la galerie
-- Utiliser pour afficher les cocktails dans la galerie non connecté
-- ou lorsque l'option "ce que je peux faire" n'est pas sélectionné
-- dans la galerie connecté
-- param_orderby: 'date' ou 'like'
DROP PROCEDURE IF EXISTS GetCocktailGalerieNonFiltrer;

CREATE PROCEDURE GetCocktailGalerieNonFiltrer(IN param_orderby
VARCHAR(50))
BEGIN
	SELECT C.id_cocktail
	FROM Cocktail C
	ORDER BY
	    CASE
	        WHEN param_orderby = 'date' THEN C.date_publication
	        WHEN param_orderby = 'like' THEN C.nb_like
	        ELSE C.nb_like
	    END DESC;
END
//

--Création de la procédure GetCocktailGalerieFiltrer
-- Permet de voir tous les cocktails que chaque utilisateur peut faire
-- Utiliser pour afficher les cocktails dans la galerie connecté lorsque
-- l'option "ce que je peux faire" est sélectionné
-- param_orderby: 'date' ou 'like'
DROP PROCEDURE IF EXISTS GetCocktailGalerieFiltrer;

CREATE PROCEDURE GetCocktailGalerieFiltrer(IN utilisateur
INT, IN param_orderby VARCHAR(50))
BEGIN
	SELECT C.id_cocktail
	FROM Cocktail C
	WHERE
	    NOT EXISTS (
	        SELECT IC.id_cocktail
	        FROM
	            Ingredient_Cocktail IC
	            LEFT JOIN Ingredient_Utilisateur IU ON IC.id_ingredient = IU.id_ingredient
	            LEFT JOIN Alcool_Utilisateur AU ON IC.id_alcool = AU.id_alcool
	        WHERE
	            IC.id_cocktail = C.id_cocktail
	            AND (
	                (
	                    IC.id_ingredient IS NOT NULL
	                    AND IU.id_utilisateur ! = utilisateur
	                )
	                OR (
	                    IC.id_alcool IS NOT NULL
	                    AND AU.id_utilisateur ! = utilisateur
	                )
	            )
	    )
	ORDER BY
	    CASE
	        WHEN param_orderby = 'date' THEN C.date_publication
	        WHEN param_orderby = 'like' THEN C.nb_like
	        ELSE C.nb_like
	    END DESC;
END
//

--Création de la procédure GetListeIngredientsCocktail
-- Permet d'avoir les informations importantes
-- qui concerne les ingrédients de chaque cocktail
-- Utiliser pour afficher les ingrédients dans la page de chaque cocktail
DROP PROCEDURE IF EXISTS GetListeIngredientsCocktail;

CREATE PROCEDURE GetListeIngredientsCocktail(IN cocktail
INT)
BEGIN
	SELECT IC.quantite, IC.unite, I.nom
	FROM
	    Ingredient_Cocktail IC
	    JOIN Ingredient I ON IC.id_ingredient = I.id_ingredient
	WHERE
	    IC.id_cocktail = cocktail
	UNION ALL
	SELECT IC.quantite, IC.unite, A.nom
	FROM
	    Ingredient_Cocktail IC
	    JOIN Alcool A ON IC.id_alcool = A.id_alcool
	WHERE
	    IC.id_cocktail = cocktail
	UNION ALL
	SELECT IC.quantite, IC.unite, IC.ingredient_autre as nom
	FROM Ingredient_Cocktail IC
	WHERE
	    IC.id_alcool IS NULL
	    AND IC.id_ingredient IS NULL
	    AND IC.id_cocktail = cocktail;
END
//

-- Création de la procédure GetInfoCocktailSimple
-- Renvoie les informations d'un cocktail pour l'affichage simple
-- Utiliser pour afficher les cocktails sous format simple(image, nom, profil saveur
-- alcool principale et nb de like)
-- *Vérfier si mieux de renoyer tous les infos d'un cocktail d'un coup et storer dans objet php
DROP PROCEDURE IF EXISTS GetInfoCocktailSimple;

CREATE PROCEDURE GetInfoCocktailSimple(IN cocktail
INT)
BEGIN
	SELECT C.nom, C.profil_saveur, C.nb_like, A.nom AS alcool_principale, BI.img
	FROM
	    Cocktail C
	    JOIN Alcool A ON C.id_alcool = A.id_alcool
	    JOIN Banque_Image BI ON C.id_image = BI.id_image
	WHERE
	    C.id_cocktail = cocktail;
END
//

-- Création de la procédure GetInfoCocktailComplet
-- Renvoie les informations d'un cocktail pour l'affichage complet
-- Utiliser pour afficher les cocktails lorsqu'ils sont sélectionnés
-- *Vérifier si nécessaire de renvoyer alcool_principale
-- *Vérifier si nécessaire de renvoyer les infos déja envoyer dans GetInfoCocktailSimple(Objet Cocktail)
DROP PROCEDURE IF EXISTS GetInfoCocktailComplet;

CREATE PROCEDURE GetInfoCocktailComplet(IN cocktail
INT)
BEGIN
	SELECT
	    C.id_cocktail,
	    C.nom,
	    C.desc_cocktail,
	    C.preparation,
	    BI.img as imgCocktail,
	    BI2.img as imgAuteur,
	    U.nom AS auteur,
	    C.date_publication,
	    C.nb_like,
	    A.nom AS alcool_principale,
	    C.profil_saveur,
	    C.type_verre
	FROM
	    Cocktail C
	    JOIN Utilisateur U ON C.id_utilisateur = U.id_utilisateur
	    JOIN Banque_Image BI ON C.id_image = BI.id_image
	    JOIN Alcool A ON C.id_alcool = A.id_alcool
	    JOIN Banque_Image BI2 ON U.id_image = BI2.id_image
	WHERE
	    C.id_cocktail = cocktail;
END
//

--Création de la procédure GetMesCocktails
-- Permet de voir les cocktails que chaque utilisateur a créé
-- Utiliser pour liste la liste de cocktail dans mon profil
DROP PROCEDURE IF EXISTS GetMesCocktails;

CREATE PROCEDURE GetMesCocktails(IN id_utilisateur
INT)
BEGIN
	SELECT C.id_cocktail
	FROM Cocktail C
	WHERE
	    C.id_utilisateur = id_utilisateur
	ORDER BY C.date_publication ASC;
END
//

--Création de la procédure GetMesIngredients
-- Permet de voir les ingrédients que chaque utilisateur possède
-- Utiliser pour lister les ingrédients dans la section mon bar qu'un utilisateur possède
DROP PROCEDURE IF EXISTS GetMesIngredients;

CREATE PROCEDURE GetMesIngredients(IN id_utilisateur
INT)
BEGIN
	SELECT I.nom
	FROM
	    Ingredient_Utilisateur IU
	    JOIN Ingredient I ON IU.id_ingredient = I.id_ingredient
	WHERE
	    IU.id_utilisateur = id_utilisateur
	UNION ALL
	SELECT A.nom
	FROM
	    Alcool_utilisateur AU
	    JOIN Alcool A ON AU.id_alcool = A.id_alcool
	WHERE
	    AU.id_utilisateur = id_utilisateur;
END
//

--Création de la procédure GetCocktailPossibleFavorie
-- Permet de voir les cocktails qu'un utilisateur à aimé et
-- qu'il peut faire avec les ingrédients qu'il possède
-- Utiliser pour lister les cocktails favoris dans la section mon bar
DROP PROCEDURE IF EXISTS GetListeCocktailPossibleFavorie;

CREATE PROCEDURE GetListeCocktailPossibleFavorie(IN
id_utilisateur INT)
BEGIN
	SELECT C.id_cocktail
	FROM Cocktail C
	    JOIN cocktail_liked CL ON C.id_cocktail = CL.id_cocktail
	WHERE
	    CL.id_utilisateur = id_utilisateur
	ORDER BY CL.date_like DESC;
END
//

--Création de la procédure GetCocktailsPossibleClassique
-- Permet de voir les cocktails classiques que chaque utilisateur peut faire
-- Utiliser pour lister les cocktails classiques dans la section mon bar
DROP PROCEDURE IF EXISTS GetCocktailsPossibleClassique;

CREATE PROCEDURE GetCocktailsPossibleClassique(IN utilisateur
INT)
BEGIN
	SELECT C.id_cocktail
	FROM Cocktail C
	WHERE
	    NOT EXISTS (
	        SELECT IC.id_cocktail
	        FROM
	            Ingredient_Cocktail IC
	            LEFT JOIN Ingredient_Utilisateur IU ON IC.id_ingredient = IU.id_ingredient
	            LEFT JOIN Alcool_Utilisateur AU ON IC.id_alcool = AU.id_alcool
	        WHERE
	            IC.id_cocktail = C.id_cocktail
	            AND (
	                (
	                    IC.id_ingredient IS NOT NULL
	                    AND IU.id_utilisateur != utilisateur
	                )
	                OR (
	                    IC.id_alcool IS NOT NULL
	                    AND AU.id_utilisateur != utilisateur
	                )
	            )
	    )
	    AND C.classique = 1
	ORDER BY C.nb_like DESC;
END
//

--Création de la procédure GetCocktailsPossibleCommunautaire
-- Permet de voir les cocktails communautaires que chaque utilisateur peut faire
-- Utiliser pour lister les cocktails communautaires dans la section mon bar
DROP PROCEDURE IF EXISTS GetCocktailsPossibleCommunautaire;

CREATE PROCEDURE GetCocktailsPossibleCommunautaire(
IN utilisateur INT)
BEGIN
	SELECT C.id_cocktail
	FROM Cocktail C
	WHERE
	    NOT EXISTS (
	        SELECT IC.id_cocktail
	        FROM
	            Ingredient_Cocktail IC
	            LEFT JOIN Ingredient_Utilisateur IU ON IC.id_ingredient = IU.id_ingredient
	            LEFT JOIN Alcool_Utilisateur AU ON IC.id_alcool = AU.id_alcool
	        WHERE
	            IC.id_cocktail = C.id_cocktail
	            AND (
	                (
	                    IC.id_ingredient IS NOT NULL
	                    AND IU.id_utilisateur != utilisateur
	                )
	                OR (
	                    IC.id_alcool IS NOT NULL
	                    AND AU.id_utilisateur != utilisateur
	                )
	            )
	    )
	    AND C.classique = 0
	ORDER BY C.nb_like DESC;
END
//

--Création de la procédure GetlisteIngredients
-- Permet d'avoir tout les ingrédients(Alcool et Ingredient) de la base de donnée
-- Utiliser pour lister les ingrédients à ajouter dans un cocktail
-- ou dans mon bar
DROP PROCEDURE IF EXISTS GetlisteIngredients;

CREATE PROCEDURE GetlisteIngredients()
BEGIN
	SELECT I.nom
	FROM Ingredient I
	UNION ALL
	SELECT A.nom
	FROM Alcool A;
END
//

--Création de la procédure GetCommentairesCocktail
-- Permet de voir les commentaires d'un cocktail
-- Utiliser pour afficher les commentaires dans la page de chaque cocktail
-- param_orderby: 'date' ou 'like'
DROP PROCEDURE IF EXISTS GetCommentairesCocktail;

CREATE PROCEDURE GetCommentairesCocktail(IN cocktail
INT, IN param_orderby VARCHAR(50))
BEGIN
	SELECT C.id_commentaire, U.nom, C.nb_like, BI.img, C.date_commentaire, C.contenu
	FROM
	    Commentaire C
	    JOIN Utilisateur U ON C.id_utilisateur = U.id_utilisateur
	    JOIN Banque_Image BI ON U.id_image = BI.id_image
	WHERE
	    C.id_cocktail = cocktail
	ORDER BY
	    CASE
	        WHEN param_orderby = 'date' THEN C.date_commentaire
	        WHEN param_orderby = 'like' THEN C.nb_like
	        ELSE C.nb_like
	    END DESC;
END
//

-- Création de la procédure RechercheCocktail
-- Permet de rechercher des cocktails par nom, ingrédient, alcool, profil saveur
-- Utiliser pour la barre de recherche
-- Renvoie tous les cocktails qui ont un des paramètres recherchés(À vérifier)
DROP PROCEDURE IF EXISTS RechercheCocktail;

CREATE PROCEDURE RechercheCocktail(IN param_recherche
VARCHAR(255), IN param_orderby VARCHAR(50))
BEGIN
	SELECT DISTINCT
	    C.id_cocktail, C.date_publication, C.nb_like
	FROM
	    Cocktail C
	    JOIN Ingredient_Cocktail IC ON C.id_cocktail = IC.id_cocktail
	    LEFT JOIN Ingredient I ON IC.id_ingredient = I.id_ingredient
	    LEFT JOIN Alcool A ON IC.id_alcool = A.id_alcool
	WHERE
	    LOCATE(C.nom, param_recherche) > 0
	    OR LOCATE(I.nom, param_recherche) > 0
	    OR LOCATE(A.nom, param_recherche) > 0
	    OR LOCATE(
	        C.profil_saveur, param_recherche
	    ) > 0
	ORDER BY
	    CASE
	        WHEN param_orderby = 'date' THEN C.date_publication
	        WHEN param_orderby = 'like' THEN C.nb_like
	        ELSE C.nb_like
	    END DESC;
	/*
	SELECT C1.id_cocktail, C1.nom, C1.profil_saveur
	FROM Cocktail C1
	WHERE NOT EXISTS (
	SELECT C2.id_cocktail
	FROM Cocktail C2
	JOIN Ingredient_Cocktail IC1 ON  C2.id_cocktail = IC1.id_cocktail
	LEFT JOIN Ingredient I1 ON IC1.id_ingredient = I1.id_ingredient
	LEFT JOIN Alcool A1 ON IC1.id_alcool = A1.id_alcool
	WHERE ((LOCATE(C2.nom, param_recherche) = 0) OR (LOCATE(I1.nom, param_recherche) = 0) OR (LOCATE(A1.nom,param_recherche) = 0)) AND C1.id_cocktail = C2.id_cocktail
	);
	*/
END
//

--Création de la procédure getInfoUtilisateur
-- Permet de voir les informations d'un utilisateur
-- Utiliser pour afficher les informations d'un utilisateur
-- dans mon profil.
DROP PROCEDURE IF EXISTS GetInfoUtilisateur;

CREATE PROCEDURE GetInfoUtilisateur(IN id_utilisateur
INT)
BEGIN
	SELECT U.nom, U.courriel, BI.img
	FROM
	    Utilisateur U
	    JOIN Banque_Image BI ON U.id_image = BI.id_image
	WHERE
	    U.id_utilisateur = id_utilisateur;
END
//


DELIMITER;

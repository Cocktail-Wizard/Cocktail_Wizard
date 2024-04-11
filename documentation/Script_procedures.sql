-- Active: 1712109793272@@cocktailwizardbd.mysql.database.azure.com@3306@cocktailwizardbd
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

-- indexe pas sur column qui change

-- Azure blobl storage pour les images


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

CREATE PROCEDURE InscriptionUtilisateur(
    IN var_nom VARCHAR(100),
    IN var_courriel VARCHAR(255),
    IN var_mdp_hashed VARCHAR(255),
    IN var_date_naissance DATE)
BEGIN
	INSERT INTO Utilisateur (nom, courriel, mdp_hashed, date_naiss)
	VALUES (var_nom, var_courriel, var_mdp_hashed, var_date_naissance);

	SELECT LAST_INSERT_ID() AS id_utilisateur;
END
//

--Création de la procédure ConnexionUtilisateur
-- Renvoie le mot_de_passe_hashé afin de vérifier si le mot de passe est correct
-- Utiliser pour la connexion
DROP PROCEDURE IF EXISTS ConnexionUtilisateur;
CREATE PROCEDURE ConnexionUtilisateur(IN var_nom VARCHAR(255))
BEGIN
    SELECT mdp_hashed FROM Utilisateur WHERE nom = var_nom;
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
INT, IN var_nom_ingredient VARCHAR(255))
BEGIN
    IF var_nom_ingredient IN (
        SELECT nom
        FROM Ingredient
    ) THEN
        INSERT INTO Ingredient_Utilisateur (
            id_utilisateur, id_ingredient
        )
        VALUES (
            var_id_utilisateur,
            (
                SELECT id_ingredient
                FROM Ingredient
                WHERE nom = var_nom_ingredient
            )
        );
    ELSEIF var_nom_ingredient IN (
        SELECT nom
        FROM Alcool
    ) THEN
        INSERT INTO Alcool_Utilisateur (
            id_utilisateur, id_alcool
        )
        VALUES (
            var_id_utilisateur,
            (
                SELECT id_alcool
                FROM Alcool
                WHERE nom = var_nom_ingredient
            )
        );
    END IF;

    CALL GetMesIngredients (var_id_utilisateur);
END
//


--Création de la procédure RetraitIngredient
-- Permet d'enlerver un ingrédient à un utilisateur
-- Utiliser pour enlever un ingrédient dans mon bar
DROP PROCEDURE IF EXISTS RetraitIngredient;

CREATE PROCEDURE RetraitIngredient(IN var_id_utilisateur
INT, IN var_nom_ingredient VARCHAR(255))
BEGIN
    IF var_nom_ingredient IN (
        SELECT nom
        FROM Ingredient
    ) THEN
        DELETE FROM Ingredient_Utilisateur
        WHERE
            id_utilisateur = var_id_utilisateur
            AND id_ingredient = (
                SELECT id_ingredient
                FROM Ingredient
                WHERE nom = var_nom_ingredient
            );
    ELSEIF var_nom_ingredient IN (
        SELECT nom
        FROM Alcool
    ) THEN
        DELETE FROM Alcool_Utilisateur
        WHERE
            id_utilisateur = var_id_utilisateur
            AND id_alcool = (
                SELECT id_alcool
                FROM Alcool
                WHERE nom = var_nom_ingredient
            );
    END IF;

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
    INSERT INTO cocktail_liked (id_cocktail, id_utilisateur)
    VALUES (
            var_id_cocktail, var_id_utilisateur
    );

    SELECT C.nb_like
    FROM Cocktail C
    WHERE id_cocktail = var_id_cocktail;
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
    WHERE id_cocktail = var_id_cocktail
        AND id_utilisateur = var_id_utilisateur;

    IF ROW_COUNT() > 0 THEN
        SELECT C.nb_like
        FROM Cocktail C
        WHERE id_cocktail = var_id_cocktail;
    ELSE
        SELECT * FROM Cocktail WHERE 1=0;
    END IF;
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
    INSERT INTO commentaire_liked (id_commentaire, id_utilisateur)
    VALUES (var_id_commentaire, var_id_utilisateur);

    SELECT C.nb_like
    FROM Commentaire C
    WHERE id_commentaire = var_id_commentaire;
END
//

--Création de la procédure DislikeCommentaire
-- Permet de disliker un commentaire et renvoyer le nouveau nombre de like
-- du commentaire
-- Utiliser pour disliker un commentaire
DROP PROCEDURE IF EXISTS DislikeCommentaire;

CREATE PROCEDURE DislikeCommentaire(IN var_id_commentaire INT, IN var_id_utilisateur INT)
BEGIN
    DELETE FROM commentaire_liked
    WHERE id_commentaire = var_id_commentaire
        AND id_utilisateur = var_id_utilisateur;

    SELECT C.nb_like
    FROM Commentaire C
    WHERE id_commentaire = var_id_commentaire;
END
//

-- Création d'un cocktail

-- Création de la procédure CreerCocktail
-- Permet de créer un cocktail
-- Utiliser pour la création de cocktail. Le id_cocktail est retourné afin de
-- pouvoir l'utiliser lors de l'ajout des ingrédients cocktails.
DROP PROCEDURE IF EXISTS CreerCocktail;

CREATE PROCEDURE CreerCocktail(
    IN var_nom VARCHAR(255),
    IN var_desc_cocktail TEXT,
    IN var_preparation TEXT,
    IN var_type_verre VARCHAR(50),
    IN var_profil_saveur VARCHAR(50),
    IN var_id_utilisateur INT,
    IN var_alcool_principal VARCHAR(255),
    IN var_image_id INT
)
BEGIN
    INSERT INTO Cocktail (
        nom, desc_cocktail, preparation, type_verre, profil_saveur, id_utilisateur, id_alcool, id_image
    )
    VALUES (
        var_nom, var_desc_cocktail, var_preparation,
        var_type_verre, var_profil_saveur, var_id_utilisateur,
        (SELECT id_alcool FROM Alcool WHERE nom = var_alcool_principal),
        var_image_id
    );
    SELECT LAST_INSERT_ID() AS id_cocktail;
END
//

-- Création de la procédure AjouterImageCocktail
-- Permet d'ajouter une image à un cocktail
-- Utiliser pour la création de cocktail
DROP PROCEDURE IF EXISTS AjouterImageCocktail;
CREATE PROCEDURE AjouterImageCocktail
(
    IN var_nom_image VARCHAR(255)
)
BEGIN
    INSERT INTO Banque_Image (img, img_cocktail)
    VALUES (var_nom_image, 1);
    SELECT LAST_INSERT_ID() AS id_image;
END
//

-- Création de la procédure AjouterIngredientCocktail
-- Permet d'ajouter un ingrédient à un cocktail
-- Utiliser pour la création de cocktail
DROP PROCEDURE IF EXISTS AjouterIngredientCocktail;
CREATE PROCEDURE AjouterIngredientCocktail(
	IN var_id_cocktail INT,
	IN var_nom_ingredient VARCHAR(255),
	IN var_quantite FLOAT,
	IN var_unite VARCHAR(50)
)
BEGIN
	IF var_nom_ingredient IN (
	    SELECT nom
	    FROM Ingredient
	) THEN INSERT INTO ingredient_cocktail (
		id_cocktail, id_ingredient, quantite, unite
	)
	VALUES (
		var_id_cocktail,
		(
			SELECT id_ingredient
			FROM Ingredient
			WHERE nom = var_nom_ingredient
		),
		var_quantite,
		var_unite
	);
	ELSEIF var_nom_ingredient IN (
	    SELECT nom
	    FROM Alcool
	) THEN INSERT INTO ingredient_cocktail (
		id_cocktail, id_alcool, quantite, unite
	)
	VALUES (
		var_id_cocktail,
		(
			SELECT id_alcool
			FROM Alcool
			WHERE nom = var_nom_ingredient
		),
		var_quantite,
		var_unite
	);
	ELSE INSERT INTO ingredient_cocktail (
		id_cocktail, ingredient_autre, quantite, unite
	)
	VALUES (
		var_id_cocktail, var_nom_ingredient, var_quantite, var_unite
	);
	END IF;
END
//

-- Création de la procédure AjouterIngredientAutreCocktail
-- Permet d'ajouter un ingrédient autre à un cocktail
-- Utiliser pour la création de cocktail
DROP PROCEDURE IF EXISTS AjouterIngredientAutreCocktail;

CREATE PROCEDURE AjouterIngredientAutreCocktail(
    IN var_id_cocktail INT,
    IN var_nom_ingredient_autre VARCHAR(255),
    IN var_quantite FLOAT,
    IN var_unite VARCHAR(50)
)
BEGIN
    INSERT INTO ingredient_cocktail (
        id_cocktail, ingredient_autre, quantite, unite
    )
    VALUES (
        var_id_cocktail, var_nom_ingredient_autre, var_quantite, var_unite
    );
END
//

-- Création de la procédure AjouterCommentaireCocktail
-- Permet d'ajouter un commentaire à un cocktail
-- Utiliser pour la création de cocktail
DROP PROCEDURE IF EXISTS AjouterCommentaireCocktail;

CREATE PROCEDURE AjouterCommentaireCocktail(
    IN var_id_cocktail INT,
    IN var_id_utilisateur INT,
    IN var_contenu VARCHAR(2000)
)
BEGIN
    INSERT INTO Commentaire (
        contenu, id_utilisateur, id_cocktail
    )
    VALUES (
        var_contenu, var_id_utilisateur, var_id_cocktail
    );

    CALL GetCommentairesCocktail(var_id_cocktail, 'date');
END
//


-- Création de la procédure GetCocktailGalerieNonFiltrer
-- Permet de voir tous les cocktails de la galerie
-- Utiliser pour afficher les cocktails dans la galerie non connecté
-- ou lorsque l'option "ce que je peux faire" n'est pas sélectionnée
-- dans la galerie connecté
-- param_orderby: 'date' ou 'like'
DROP PROCEDURE IF EXISTS GetCocktailGalerieNonFiltrer;

CREATE PROCEDURE GetCocktailGalerieNonFiltrer(IN param_orderby VARCHAR(50))
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

-- Création de la procédure GetCocktailGalerieFiltrer
-- Permet de voir tous les cocktails que chaque utilisateur peut faire
-- Utiliser pour afficher les cocktails dans la galerie connecté lorsque
-- l'option "ce que je peux faire" est sélectionnée
-- param_orderby: 'date' ou 'like'
DROP PROCEDURE IF EXISTS GetCocktailGalerieFiltrer;

CREATE PROCEDURE GetCocktailGalerieFiltrer(IN utilisateur INT, IN param_orderby VARCHAR(50))
BEGIN
    SELECT C.id_cocktail, (SELECT COUNT(IC.id_ingredient_cocktail)
        FROM Ingredient_Cocktail IC
        LEFT JOIN Ingredient I ON IC.id_ingredient = I.id_ingredient
        LEFT JOIN Alcool A ON IC.id_alcool = A.id_alcool
        WHERE IC.id_cocktail = C.id_cocktail
        AND(
            (IC.id_alcool IS NOT NULL AND NOT EXISTS (SELECT id_alcool FROM Alcool_Utilisateur WHERE id_alcool = IC.id_alcool AND id_utilisateur = utilisateur))
            OR (IC.id_ingredient IS NOT NULL AND NOT EXISTS (SELECT id_ingredient FROM Ingredient_Utilisateur WHERE id_ingredient = IC.id_ingredient AND id_utilisateur = utilisateur))
        )
    ) AS ing_manquant
    FROM Cocktail C
    ORDER BY ing_manquant ASC,
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

CREATE PROCEDURE GetListeIngredientsCocktail(IN cocktail INT)
BEGIN
    SELECT IC.quantite, IC.unite, I.nom
    FROM Ingredient_Cocktail IC
    JOIN Ingredient I ON IC.id_ingredient = I.id_ingredient
    WHERE IC.id_cocktail = cocktail
    UNION ALL
    SELECT IC.quantite, IC.unite, A.nom
    FROM Ingredient_Cocktail IC
    JOIN Alcool A ON IC.id_alcool = A.id_alcool
    WHERE IC.id_cocktail = cocktail
    UNION ALL
    SELECT IC.quantite, IC.unite, IC.ingredient_autre as nom
    FROM Ingredient_Cocktail IC
    WHERE IC.id_alcool IS NULL
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

CREATE PROCEDURE GetInfoCocktailSimple(IN cocktail INT)
BEGIN
    SELECT C.nom, C.profil_saveur, C.nb_like, A.nom AS alcool_principale, BI.img
    FROM Cocktail C
    JOIN Alcool A ON C.id_alcool = A.id_alcool
    JOIN Banque_Image BI ON C.id_image = BI.id_image
    WHERE C.id_cocktail = cocktail;
END
//

-- Création de la procédure GetInfoCocktailComplet
-- Renvoie les informations d'un cocktail pour l'affichage complet
-- Utiliser pour afficher les cocktails lorsqu'ils sont sélectionnés
-- *Vérifier si nécessaire de renvoyer alcool_principale
-- *Vérifier si nécessaire de renvoyer les infos déja envoyer dans GetInfoCocktailSimple(Objet Cocktail)
DROP PROCEDURE IF EXISTS GetInfoCocktailComplet;

CREATE PROCEDURE GetInfoCocktailComplet(IN cocktail INT)
BEGIN
    SELECT C.id_cocktail, C.nom, C.desc_cocktail, C.preparation, BI.img as imgCocktail, BI2.img as imgAuteur, U.nom AS auteur, C.date_publication, C.nb_like, A.nom AS alcool_principale, C.profil_saveur, C.type_verre
    FROM Cocktail C
    JOIN Utilisateur U ON C.id_utilisateur = U.id_utilisateur
    -- Enlever LEFT quand les images seront gérées
    LEFT JOIN Banque_Image BI ON C.id_image = BI.id_image
    JOIN Alcool A ON C.id_alcool = A.id_alcool
    -- Enlever LEFT quand les images seront gérées
    LEFT JOIN Banque_Image BI2 ON U.id_image = BI2.id_image
    WHERE C.id_cocktail = cocktail;
END
//

-- Création de la procédure cocktailLiked
-- Permet de voir si un utilisateur a liké un cocktail
DROP PROCEDURE IF EXISTS cocktailLiked;

CREATE PROCEDURE cocktailLiked(IN var_id_cocktail INT, IN var_id_utilisateur INT)
BEGIN
    IF EXISTS (
        SELECT id_cocktail
        FROM cocktail_liked
        WHERE id_cocktail = var_id_cocktail
        AND id_utilisateur = var_id_utilisateur
    ) THEN
        SELECT 1 AS liked;
    ELSE
        SELECT 0 AS liked;
    END IF;
END
//

--Création de la procédure GetMesCocktails
-- Permet de voir les cocktails que chaque utilisateur a créé
-- Utiliser pour liste la liste de cocktail dans mon profil
DROP PROCEDURE IF EXISTS GetMesCocktails;

CREATE PROCEDURE GetMesCocktails(IN id_utilisateur INT)
BEGIN
    SELECT C.id_cocktail
    FROM Cocktail C
    WHERE C.id_utilisateur = id_utilisateur
    ORDER BY C.date_publication ASC;
END
//

--Création de la procédure GetMesIngredients
-- Permet de voir les ingrédients que chaque utilisateur possède
-- Utiliser pour lister les ingrédients dans la section mon bar qu'un utilisateur possède
DROP PROCEDURE IF EXISTS GetMesIngredients;

CREATE PROCEDURE GetMesIngredients(IN id_utilisateur INT)
BEGIN
    SELECT I.nom
    FROM Ingredient_Utilisateur IU
    JOIN Ingredient I ON IU.id_ingredient = I.id_ingredient
    WHERE IU.id_utilisateur = id_utilisateur
    UNION ALL
    SELECT A.nom
    FROM Alcool_utilisateur AU
    JOIN Alcool A ON AU.id_alcool = A.id_alcool
    WHERE AU.id_utilisateur = id_utilisateur;
END
//

--Création de la procédure GetCocktailPossibleFavorie
-- Permet de voir les cocktails qu'un utilisateur à aimé et
-- qu'il peut faire avec les ingrédients qu'il possède
-- Utiliser pour lister les cocktails favoris dans la section mon bar
DROP PROCEDURE IF EXISTS GetListeCocktailPossibleFavorie;

CREATE PROCEDURE GetListeCocktailPossibleFavorie(IN id_utilisateur INT)
BEGIN
    SELECT C.id_cocktail, (SELECT COUNT(IC.id_ingredient_cocktail)
        FROM Ingredient_Cocktail IC
        LEFT JOIN Ingredient I ON IC.id_ingredient = I.id_ingredient
        LEFT JOIN Alcool A ON IC.id_alcool = A.id_alcool
        WHERE IC.id_cocktail = C.id_cocktail
        AND(
            (IC.id_alcool IS NOT NULL AND NOT EXISTS (SELECT id_alcool FROM Alcool_Utilisateur AU WHERE AU.id_alcool = IC.id_alcool AND AU.id_utilisateur = id_utilisateur))
            OR (IC.id_ingredient IS NOT NULL AND NOT EXISTS (SELECT id_ingredient FROM Ingredient_Utilisateur IU WHERE IU.id_ingredient = IC.id_ingredient AND IU.id_utilisateur = id_utilisateur))
        )) AS ing_manquant
    FROM Cocktail C
    JOIN cocktail_liked CL ON C.id_cocktail = CL.id_cocktail
    WHERE CL.id_utilisateur = id_utilisateur
    ORDER BY ing_manquant ASC, CL.date_like DESC;
END
//

--Création de la procédure GetCocktailsPossibleClassique
-- Permet de voir les cocktails classiques que chaque utilisateur peut faire
-- Utiliser pour lister les cocktails classiques dans la section mon bar
DROP PROCEDURE IF EXISTS GetCocktailsPossibleClassique;

CREATE PROCEDURE GetCocktailsPossibleClassique(IN utilisateur INT)
BEGIN
    SELECT C.id_cocktail, (SELECT COUNT(IC.id_ingredient_cocktail)
        FROM Ingredient_Cocktail IC
        LEFT JOIN Ingredient I ON IC.id_ingredient = I.id_ingredient
        LEFT JOIN Alcool A ON IC.id_alcool = A.id_alcool
        WHERE IC.id_cocktail = C.id_cocktail
        AND(
            (IC.id_alcool IS NOT NULL AND NOT EXISTS (SELECT id_alcool FROM Alcool_Utilisateur WHERE id_alcool = IC.id_alcool AND id_utilisateur = utilisateur))
            OR (IC.id_ingredient IS NOT NULL AND NOT EXISTS (SELECT id_ingredient FROM Ingredient_Utilisateur WHERE id_ingredient = IC.id_ingredient AND id_utilisateur = utilisateur))
        )
    ) AS ing_manquant
    FROM Cocktail C
    WHERE C.classique = 1
    ORDER BY ing_manquant ASC, C.nb_like DESC;
END
//

--Création de la procédure GetCocktailsPossibleCommunautaire
-- Permet de voir les cocktails communautaires que chaque utilisateur peut faire
-- Utiliser pour lister les cocktails communautaires dans la section mon bar
DROP PROCEDURE IF EXISTS GetCocktailsPossibleCommunautaire;

CREATE PROCEDURE GetCocktailsPossibleCommunautaire(IN utilisateur INT)
BEGIN
    SELECT C.id_cocktail, (SELECT COUNT(IC.id_ingredient_cocktail)
        FROM Ingredient_Cocktail IC
        LEFT JOIN Ingredient I ON IC.id_ingredient = I.id_ingredient
        LEFT JOIN Alcool A ON IC.id_alcool = A.id_alcool
        WHERE IC.id_cocktail = C.id_cocktail
        AND(
            (IC.id_alcool IS NOT NULL AND NOT EXISTS (SELECT id_alcool FROM Alcool_Utilisateur WHERE id_alcool = IC.id_alcool AND id_utilisateur = utilisateur))
            OR (IC.id_ingredient IS NOT NULL AND NOT EXISTS (SELECT id_ingredient FROM Ingredient_Utilisateur WHERE id_ingredient = IC.id_ingredient AND id_utilisateur = utilisateur))
        )
    ) AS ing_manquant
    FROM Cocktail C
    WHERE C.classique = 0
    ORDER BY ing_manquant ASC, C.nb_like DESC;
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

CREATE PROCEDURE GetCommentairesCocktail(IN cocktail INT, IN param_orderby VARCHAR(50))
BEGIN
    SELECT C.id_commentaire, U.nom, C.nb_like, BI.img, C.date_commentaire, C.contenu
    FROM Commentaire C
    JOIN Utilisateur U ON C.id_utilisateur = U.id_utilisateur
    -- Enlever LEFT quand les images seront gérées
    LEFT JOIN Banque_Image BI ON U.id_image = BI.id_image
    WHERE C.id_cocktail = cocktail
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

CREATE PROCEDURE RechercheCocktail(IN param_recherche VARCHAR(255), IN param_orderby VARCHAR(50))
BEGIN
    SELECT DISTINCT C.id_cocktail, C.date_publication, C.nb_like
    FROM Cocktail C
    JOIN Ingredient_Cocktail IC ON C.id_cocktail = IC.id_cocktail
    LEFT JOIN Ingredient I ON IC.id_ingredient = I.id_ingredient
    LEFT JOIN Alcool A ON IC.id_alcool = A.id_alcool
    WHERE LOCATE(param_recherche ,C.nom) > 0
    OR LOCATE(param_recherche , I.nom) > 0
    OR LOCATE( param_recherche,A.nom) > 0
    OR LOCATE(param_recherche ,C.profil_saveur) > 0
    ORDER BY
        CASE
            WHEN param_orderby = 'date' THEN C.date_publication
            WHEN param_orderby = 'like' THEN C.nb_like
            ELSE C.nb_like
        END DESC;
END
//

-- Création de la procédure RechercheCocktailFiltrer
-- Permet de rechercher des cocktails par nom, ingrédient, alcool, profil saveur
-- et de filtrer les cocktails que l'utilisateur peut faire.
-- Utiliser pour la barre de recherche quand l'option "ce que je peux faire" est sélectionnée
DROP PROCEDURE IF EXISTS RechercheCocktailFiltrer;

CREATE PROCEDURE RechercheCocktailFiltrer(
    IN param_recherche VARCHAR(255), IN id_utilisateur INT, IN param_orderby VARCHAR(50)
)
BEGIN
    SELECT DISTINCT C.id_cocktail, C.date_publication, C.nb_like
    FROM Cocktail C
    JOIN Ingredient_Cocktail IC ON C.id_cocktail = IC.id_cocktail
    LEFT JOIN Ingredient I ON IC.id_ingredient = I.id_ingredient
    LEFT JOIN Alcool A ON IC.id_alcool = A.id_alcool
    WHERE (LOCATE(C.nom, param_recherche) > 0
    OR LOCATE(I.nom, param_recherche) > 0
    OR LOCATE(A.nom, param_recherche) > 0
    OR LOCATE(C.profil_saveur, param_recherche) > 0)
    AND (
        (IC.id_alcool IS NOT NULL AND NOT EXISTS (SELECT id_alcool FROM Alcool_Utilisateur AU WHERE AU.id_alcool = IC.id_alcool AND AU.id_utilisateur = id_utilisateur))
            OR (IC.id_ingredient IS NOT NULL AND NOT EXISTS (SELECT id_ingredient FROM Ingredient_Utilisateur IU WHERE IU.id_ingredient = IC.id_ingredient AND IU.id_utilisateur = id_utilisateur))
    )
    ORDER BY
        CASE
            WHEN param_orderby = 'date' THEN C.date_publication
            WHEN param_orderby = 'like' THEN C.nb_like
            ELSE C.nb_like
        END DESC;
END
//

--Création de la procédure getInfoUtilisateur
-- Permet de voir les informations d'un utilisateur
-- Utiliser pour afficher les informations d'un utilisateur
-- dans mon profil.
DROP PROCEDURE IF EXISTS GetInfoUtilisateur;

CREATE PROCEDURE GetInfoUtilisateur(IN id_utilisateur INT)
BEGIN
    SELECT U.nom, U.courriel, BI.img, COUNT(DISTINCT CL.id_cocktail) AS nb_cocktail_liked, COUNT(DISTINCT CO.id_commentaire) AS nb_commentaire, COUNT(DISTINCT C.id_cocktail) as nb_cocktail
    FROM Utilisateur U
    LEFT JOIN Banque_Image BI ON U.id_image = BI.id_image
    LEFT JOIN cocktail_liked CL ON U.id_utilisateur = CL.id_utilisateur
    LEFT JOIN commentaire CO ON U.id_utilisateur = CO.id_utilisateur
    LEFT JOIN cocktail C ON U.id_utilisateur = C.id_utilisateur
    WHERE U.id_utilisateur = id_utilisateur
    GROUP BY U.id_utilisateur;
END
//


-- Création de la procédure ModifierMotDePasse
-- Permet de modifier le mot de passe d'un utilisateur
-- Utiliser pour modifier le mot de passe dans mon profil
DROP PROCEDURE IF EXISTS ModifierMotDePasse;

CREATE PROCEDURE ModifierMotDePasse(IN var_id_utilisateur INT, IN var_mdp_hashed VARCHAR(255))
BEGIN
    UPDATE Utilisateur
    SET mdp_hashed = var_mdp_hashed
    WHERE id_utilisateur = var_id_utilisateur;
END
//

-- Création de la procédure SupprimerCompte
-- Permet de supprimer un compte utilisateur
-- Utiliser pour supprimer un compte dans mon profil
DROP PROCEDURE IF EXISTS SupprimerCompte;

CREATE PROCEDURE SupprimerCompte(IN var_id_utilisateur INT)
BEGIN

    CREATE TEMPORARY TABLE temp_cocktails AS
    SELECT id_cocktail
    FROM Cocktail
    WHERE id_utilisateur = var_id_utilisateur;

    CREATE TEMPORARY TABLE temp_commentaire AS
    SELECT id_commentaire
    FROM commentaire
    WHERE id_utilisateur = var_id_utilisateur;

    DELETE FROM Ingredient_Utilisateur
    WHERE id_utilisateur = var_id_utilisateur;
    DELETE FROM Alcool_Utilisateur
    WHERE id_utilisateur = var_id_utilisateur;
    DELETE FROM cocktail_liked
    WHERE id_utilisateur = var_id_utilisateur
    OR id_cocktail IN (SELECT id_cocktail FROM temp_cocktails);
    DELETE FROM commentaire_liked
    WHERE id_utilisateur = var_id_utilisateur
    OR id_commentaire IN (SELECT id_commentaire temp_commentaire)
    OR id_commentaire IN (SELECT id_commentaire
        FROM Commentaire
        WHERE id_cocktail IN (SELECT id_cocktail FROM temp_cocktails));
    DELETE FROM commentaire
    WHERE id_utilisateur = var_id_utilisateur
    OR id_cocktail IN (SELECT id_cocktail FROM temp_cocktails);
    DELETE FROM ingredient_cocktail
    WHERE id_cocktail IN (
        SELECT id_cocktail
        FROM Cocktail
        WHERE id_utilisateur = var_id_utilisateur
    );
    DELETE FROM cocktail
    WHERE id_utilisateur = var_id_utilisateur;


    DROP TABLE temp_cocktails;
    DROP TABLE temp_commentaire;

    DELETE FROM utilisateur
    WHERE id_utilisateur = var_id_utilisateur;

    IF ROW_COUNT() > 0 THEN
        SELECT 1 AS success;
    ELSE
        SELECT 0 AS success;
    END IF;
END
//

-- Création de la procédure supprimerCocktail
-- Permet de supprimer un cocktail
-- Utiliser pour supprimer un cocktail dans mon profil
DROP PROCEDURE IF EXISTS SupprimerCocktail;

CREATE PROCEDURE SupprimerCocktail(IN var_id_cocktail INT)
BEGIN
    DELETE FROM cocktail_liked
    WHERE id_cocktail = var_id_cocktail;
    CALL SupprimerCommentaireDeCocktail(var_id_cocktail);
    DELETE FROM ingredient_cocktail
    WHERE id_cocktail = var_id_cocktail;
    DELETE FROM cocktail
    WHERE id_cocktail = var_id_cocktail;
    IF ROW_COUNT() > 0 THEN
        SELECT 1 AS success;
    ELSE
        SELECT 0 AS success;
    END IF;
END
//


-- Création de la procédure supprimerCommentaire
-- Permet de supprimer un commentaire
DROP PROCEDURE IF EXISTS SupprimerCommentaire;

CREATE PROCEDURE SupprimerCommentaire(IN var_id_commentaire INT)
BEGIN
    DELETE FROM commentaire_liked
    WHERE id_commentaire = var_id_commentaire;
    DELETE FROM commentaire
    WHERE id_commentaire = var_id_commentaire;
    IF ROW_COUNT() > 0 THEN
        SELECT 1 AS success;
    ELSE
        SELECT 0 AS success;
    END IF;
END
//

-- Création de la procédure supprimerCommentaireDeCocktail
-- Permet de supprimer les commentaires d'un cocktail`
DROP PROCEDURE IF EXISTS SupprimerCommentaireDeCocktail;

CREATE PROCEDURE SupprimerCommentaireDeCocktail(IN var_id_cocktail INT)
BEGIN
    DELETE FROM commentaire_liked
    WHERE id_commentaire IN (
        SELECT id_commentaire
        FROM Commentaire
        WHERE id_cocktail = var_id_cocktail
    );
    DELETE FROM commentaire
    WHERE id_cocktail = var_id_cocktail;
END
//

-- Création de la procédure ajoutIngredientBD
-- Permet d'ajouter un ingrédient dans la base de donnée afin que celui ci puisse être utilisé
-- lors de la création de cocktail
DROP PROCEDURE IF EXISTS ajoutIngredientBD

CREATE PROCEDURE ajoutIngredientBD(IN var_ingredient VARCHAR(255))
BEGIN
    IF EXISTS (
        SELECT nom
        FROM Ingredient
        WHERE nom = var_ingredient
    )
    THEN
        SELECT 0 AS success;
    ELSE
        INSERT INTO Ingredient (nom)
        VALUES (var_ingredient);
        SELECT 1 AS success;
    END IF;
END
//

-- Création de la procédure ajoutAlcoolBD
-- Permet d'ajouter un alcool dans la base de donnée afin que celui ci puisse être utilisé
-- lors de la création de cocktail
DROP PROCEDURE IF EXISTS ajoutAlcoolBD

CREATE PROCEDURE ajoutAlcoolBD(IN var_alcool VARCHAR(255))
BEGIN
    IF EXISTS (
        SELECT nom
        FROM Alcool
        WHERE nom = var_alcool
    )
    THEN
        SELECT 0 AS success;
    ELSE
        INSERT INTO Alcool (nom)
        VALUES (var_alcool);
        SELECT 1 AS success;
    END IF;
END
//

DELIMITER ;

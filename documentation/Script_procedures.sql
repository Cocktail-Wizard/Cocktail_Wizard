-- Active: 1710380541515@@cocktailwizbd.mysql.database.azure.com@3306@cocktailwizardbd
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

-- Affiche les procédures
SHOW PROCEDURE STATUS;

DELIMITER //

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
    WHERE IC.id_alcool IS NULL AND IC.id_ingredient IS NULL AND IC.id_cocktail = cocktail;
END //

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
END //

-- Création de la procédure GetInfoCocktailComplet
-- Renvoie les informations d'un cocktail pour l'affichage complet
-- Utiliser pour afficher les cocktails lorsqu'ils sont sélectionnés
-- *Vérifier si nécessaire de renvoyer alcool_principale
-- *Vérifier si nécessaire de renvoyer les infos déja envoyer dans GetInfoCocktailSimple(Objet Cocktail)
DROP PROCEDURE IF EXISTS GetInfoCocktailComplet;
CREATE PROCEDURE GetInfoCocktailComplet(IN cocktail INT)
BEGIN
    SELECT C.nom, C.desc_cocktail, C.preparation, C.nb_like, C.date_publication, C.type_verre, C.profil_saveur, U.nom AS auteur, BI.img
    FROM Cocktail C
    JOIN Utilisateur U ON C.id_utilisateur = U.id_utilisateur
    JOIN Banque_Image BI ON C.id_image = BI.id_image
    WHERE C.id_cocktail = cocktail;
END //

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
END //

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
END //

--Création de la procédure GetCocktailPossibleFavorie
-- Permet de voir les cocktails qu'un utilisateur à aimé et
-- qu'il peut faire avec les ingrédients qu'il possède
-- Utiliser pour lister les cocktails favoris dans la section mon bar
DROP PROCEDURE IF EXISTS GetCocktailListePossibleFavorie;
CREATE PROCEDURE GetListeCocktailPossibleFavorie(IN id_utilisateur INT)
BEGIN
    SELECT C.id_cocktail
    FROM Cocktail C
    JOIN cocktail_liked CL ON C.id_cocktail = CL.id_cocktail
    WHERE CL.id_utilisateur = id_utilisateur
    ORDER BY CL.date_like DESC;
END //




--Création de la procédure GetCocktailsPossibleClassique
-- Permet de voir les cocktails classiques que chaque utilisateur peut faire
-- Utiliser pour lister les cocktails classiques dans la section mon bar
-- INCOMPLET
DROP PROCEDURE IF EXISTS GetCocktailsPossibleClassique;
CREATE PROCEDURE GetCocktailsPossibleClassique(IN utilisateur INT)
BEGIN
    SELECT C.id_cocktail
    FROM Cocktail C
    WHERE NOT EXISTS (
        SELECT IC.id_cocktail
        FROM Ingredient_Cocktail IC
        LEFT JOIN Ingredient_Utilisateur IU ON IC.id_ingredient = IU.id_ingredient
        LEFT JOIN Alcool_Utilisateur AU ON IC.id_alcool = AU.id_alcool
        WHERE IC.id_cocktail = C.id_cocktail
            AND (
            (IC.id_ingredient IS NOT NULL AND IU.id_utilisateur != utilisateur) OR
            (IC.id_alcool IS NOT NULL AND AU.id_utilisateur != utilisateur)
        )
    ) AND C.classique = 1
    ORDER BY C.nb_like DESC;
END //

--Création de la procédure GetCocktailsPossibleCommunautaire
-- Permet de voir les cocktails communautaires que chaque utilisateur peut faire
-- Utiliser pour lister les cocktails communautaires dans la section mon bar
DROP PROCEDURE IF EXISTS GetCocktailsPossibleCommunautaire;
CREATE PROCEDURE GetCocktailsPossibleCommunautaire(IN utilisateur INT)
BEGIN
    SELECT C.id_cocktail
    FROM Cocktail C
    WHERE NOT EXISTS (
        SELECT IC.id_cocktail
        FROM Ingredient_Cocktail IC
        LEFT JOIN Ingredient_Utilisateur IU ON IC.id_ingredient = IU.id_ingredient
        LEFT JOIN Alcool_Utilisateur AU ON IC.id_alcool = AU.id_alcool
        WHERE IC.id_cocktail = C.id_cocktail
            AND (
            (IC.id_ingredient IS NOT NULL AND IU.id_utilisateur != utilisateur) OR
            (IC.id_alcool IS NOT NULL AND AU.id_utilisateur != utilisateur)
        )
    ) AND C.classique = 0
    ORDER BY C.nb_like DESC;
END //

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
END //

--Création de la procédure GetCommentairesCocktail
-- Permet de voir les commentaires d'un cocktail
-- Utiliser pour afficher les commentaires dans la page de chaque cocktail
DROP PROCEDURE IF EXISTS GetCommentairesCocktail;
CREATE PROCEDURE GetCommentairesCocktail(IN cocktail INT, IN param_orderby VARCHAR(50))
BEGIN
    SELECT U.nom, C.nb_like, BI.img, C.date_commentaire, C.contenu
    FROM Commentaire C
    JOIN Utilisateur U ON C.id_utilisateur = U.id_utilisateur
    JOIN Banque_Image BI ON U.id_image = BI.id_image
    WHERE C.id_cocktail = cocktail
    ORDER BY
    CASE
        WHEN param_orderby = 'date' THEN C.date_commentaire
        WHEN param_orderby = 'like' THEN C.nb_like
        ELSE C.nb_like
    END DESC;
END //

-- Création de la procédure RechercheCocktail
-- Permet de rechercher des cocktails par nom, ingrédient, alcool, profil saveur
-- Utiliser pour la barre de recherche
DROP PROCEDURE IF EXISTS RechercheCocktail;
CREATE PROCEDURE RechercheCocktail(IN param_recherche VARCHAR(255))
BEGIN
    /*
    SELECT DISTINCT C.id_cocktail, C.nom, C.profil_saveur
    FROM Cocktail C
    JOIN Ingredient_Cocktail IC ON  C.id_cocktail = IC.id_cocktail
    LEFT JOIN Ingredient I ON IC.id_ingredient = I.id_ingredient
    LEFT JOIN Alcool A ON IC.id_alcool = A.id_alcool
    WHERE LOCATE(C.nom, param_recherche) > 0
        OR LOCATE(I.nom, param_recherche) > 0
        OR LOCATE(A.nom, param_recherche) > 0
        OR LOCATE(C.profil_saveur, param_recherche) > 0;
    */
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
END //

CALL RechercheCocktail('Mojito');

DELIMITER ;

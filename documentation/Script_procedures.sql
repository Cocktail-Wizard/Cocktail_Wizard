-- Active: 1709764745031@@cocktailwizbd.mysql.database.azure.com@3306@cocktailwizardbd
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


--Création de la procédure GetCocktailPossibleClassique
-- Permet de voir les cocktails classiques que chaque utilisateur peut faire
-- Utiliser pour lister les cocktails classiques dans la section mon bar
-- INCOMPLET
DROP PROCEDURE IF EXISTS GetCocktailPossibleClassique;
CREATE PROCEDURE GetCocktailPossibleClassique(IN id_utilisateur INT)
BEGIN
    SELECT C.id_cocktail
    FROM Cocktail C
    JOIN Ingredient_Cocktail IC ON C.id;
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




DELIMITER ;

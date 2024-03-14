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
DROP PROCEDURE IF EXISTS GetListeIngredientsCocktail;
CREATE PROCEDURE GetListeIngredientsCocktail(IN cocktail INT)
BEGIN
    SELECT IC.quantite, IC.unite, I.nom, A.nom, IC.ingredient_autre
    FROM Ingredient_Cocktail IC
    JOIN Ingredient I ON IC.id_ingredient = I.id_ingredient
    JOIN Alcool A ON IC.id_alcool = A.id_alcool
    WHERE IC.id_cocktail = cocktail;
END //

--Création de la procédure GetMesCocktails
-- Permet de voir les cocktails que chaque utilisateur a créé
DROP PROCEDURE IF EXISTS GetMesCocktails;
CREATE PROCEDURE GetMesCocktails(IN id_utilisateur INT)
BEGIN
    SELECT C.id_cocktail
    FROM Cocktail C
    WHERE C.id_utilisateur = id_utilisateur;
END //


--Création de la procédure GetMesIngredients
-- Permet de voir les ingrédients que chaque utilisateur possède
DROP PROCEDURE IF EXISTS GetMesIngredients;
CREATE PROCEDURE GetMesIngredients(IN id_utilisateur INT)
BEGIN
    SELECT A.nom, I.nom
    FROM mes_ingredients MI
    JOIN Alcool A ON MI.id_alcool = A.id_alcool
    JOIN Ingredient I ON MI.id_ingredient = I.id_ingredient
    WHERE MI.id_utilisateur = id_utilisateur;
END //
DELIMITER ;



--Création de la procédure GetCocktailPossibleClassique
-- Permet de voir les cocktails classiques que chaque utilisateur peut faire
DROP PROCEDURE IF EXISTS GetCocktailPossibleClassique;
CREATE PROCEDURE GetCocktailPossibleClassique(IN id_utilisateur INT)
BEGIN

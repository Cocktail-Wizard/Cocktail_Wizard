-- ============================================================
-- Auteurs : Yani Amellal, Léonard Marcoux, Pablo Hamel-Corôa,
--           Maxime Dmitriev et Vianney Veremme
-- Date de création : 03-03-2024
-- Description :
--  Script de création des vues de la base donnée reliée
--  au site web cocktail wizard
--
--
-- ============================================================

-- Affiche les vues
SHOW FULL TABLES IN cocktailwizardbd WHERE TABLE_TYPE LIKE 'VIEW';

/* Pas nécessaire
--Création de la vue mes_cocktails
DROP VIEW IF EXISTS mes_cocktails;
CREATE VIEW mes_cocktails AS
SELECT U.id_utilisateur,C.*
FROM Utilisateur U
JOIN Cocktail C ON U.id_utilisateur = C.id_utilisateur;
*/

--Création de la vue mes_ingredients
-- Permet de voir les ingrédients que chaque utilisateur possède
DROP VIEW IF EXISTS mes_ingredients;
CREATE VIEW mes_ingredients AS
SELECT id_utilisateur, id_ingredient AS ingredient, 0 AS type_ing
FROM Ingredient_Utilisateur
UNION ALL
SELECT id_utilisateur, id_alcool AS ingredient, 1 AS type_ing
FROM Alcool_utilisateur;

SELECT * FROM mes_ingredients;
/*
--Création de la vue liste_ingredients_cocktail
-- Permet de voir les ingrédients de chaque cocktail
DROP VIEW IF EXISTS liste_ingredients_cocktail;
CREATE VIEW liste_ingredients_cocktail AS
SELECT C.id_cocktail,
*/

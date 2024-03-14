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
DROP VIEW IF EXISTS mes_ingredients;
CREATE VIEW mes_ingredients AS
SELECT U.id_utilisateur, A.id_alcool, I.id_ingredient
FROM Utilisateur U
JOIN Ingredient_Utilisateur I ON U.id_utilisateur = I.id_utilisateur
JOIN Alcool_utilisateur A ON U.id_utilisateur = A.id_utilisateur;

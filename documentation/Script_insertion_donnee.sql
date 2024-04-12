-- ============================================================
-- Auteurs : Yani Amellal, Léonard Marcoux, Pablo Hamel-Corôa,
--           Maxime Dmitriev et Vianney Veremme
-- Date de création : 03-03-2024
-- Description :
--  Script de création de jeu de donné pour la base donnée reliée
--  au site web cocktail wizard
--  Tables: Ingredient, Alcool, Ingredient_Utilisateur,
--  Utilisateur, Alcool_utilisateur, Commentaire, Banque_Image,
--  Ingredient_Cocktail, Cocktail.
--
-- ============================================================




-- Suppression des données
SET FOREIGN_KEY_CHECKS = 0;

TRUNCATE TABLE Ingredient;

TRUNCATE TABLE Alcool;

TRUNCATE TABLE Banque_Image;

TRUNCATE TABLE Utilisateur;

TRUNCATE TABLE Ingredient_Utilisateur;

TRUNCATE TABLE Alcool_utilisateur;

TRUNCATE TABLE Cocktail;

TRUNCATE TABLE Ingredient_Cocktail;

TRUNCATE TABLE Commentaire;

TRUNCATE TABLE Commentaire_Liked;

TRUNCATE TABLE Cocktail_Liked;

SET FOREIGN_KEY_CHECKS = 1;

-- Insertion des données dans la table Ingredient
INSERT INTO Ingredient (nom) VALUES ('Sel');
INSERT INTO Ingredient (nom) VALUES ('Poivre');
INSERT INTO Ingredient (nom) VALUES ('Sucre');
INSERT INTO Ingredient (nom) VALUES ('Sirop de sucre');
INSERT INTO Ingredient (nom) VALUES ('Sirop de grenadine');
INSERT INTO Ingredient (nom) VALUES ('Sirop de menthe');
INSERT INTO Ingredient (nom) VALUES ('Sirop de vanille');
INSERT INTO Ingredient (nom) VALUES ('Sirop de fraise');
INSERT INTO Ingredient (nom) VALUES ('Sirop de framboise');
INSERT INTO Ingredient (nom) VALUES ('Sirop de pêche');
INSERT INTO Ingredient (nom) VALUES ('Sirop de citron');
INSERT INTO Ingredient (nom) VALUES ('Sirop de lime');
INSERT INTO Ingredient (nom) VALUES ('Sirop de litchi');
INSERT INTO Ingredient (nom) VALUES ('Sirop de banane');
INSERT INTO Ingredient (nom) VALUES ('Sirop de noix de coco');
INSERT INTO Ingredient (nom) VALUES ('Sirop de pomme');
INSERT INTO Ingredient (nom) VALUES ('Sirop de bleuet');
INSERT INTO Ingredient (nom) VALUES ('Sirop de cassis');
INSERT INTO Ingredient (nom) VALUES ('Sirop de ananas');
INSERT INTO Ingredient (nom) VALUES ('Sirop de mangue');
INSERT INTO Ingredient (nom) VALUES ('Sirop de papaye');
INSERT INTO Ingredient (nom) VALUES ('Sirop de kiwi');
INSERT INTO Ingredient (nom) VALUES ('Sirop de cerise');
INSERT INTO Ingredient (nom) VALUES ('Sirop de orange');
INSERT INTO Ingredient (nom) VALUES ('Sirop de pamplemousse');
INSERT INTO Ingredient (nom) VALUES ('Sirop de citron vert');
INSERT INTO Ingredient (nom) VALUES ('Sirop de citronnelle');
INSERT INTO Ingredient (nom) VALUES ('Sirop de gingembre');
INSERT INTO Ingredient (nom) VALUES ('Sirop de cardamome');
INSERT INTO Ingredient (nom) VALUES ('Sirop de cannelle');
INSERT INTO Ingredient (nom) VALUES ('Sirop de anis');
INSERT INTO Ingredient (nom) VALUES ('Sirop de réglisse');
INSERT INTO Ingredient (nom) VALUES ('Sirop de menthe verte');
INSERT INTO Ingredient (nom) VALUES ('Jus de citron');
INSERT INTO Ingredient (nom) VALUES ('Jus de lime');
INSERT INTO Ingredient (nom) VALUES ('Jus de pamplemousse');
INSERT INTO Ingredient (nom) VALUES ('Jus d''orange');
INSERT INTO Ingredient (nom) VALUES ('Jus de pomme');
INSERT INTO Ingredient (nom) VALUES ('Jus de raisin');
INSERT INTO Ingredient (nom) VALUES ('Jus de canneberge');
INSERT INTO Ingredient (nom) VALUES ('Jus de cerise');
INSERT INTO Ingredient (nom) VALUES ('Jus de ananas');
INSERT INTO Ingredient (nom) VALUES ('Jus de mangue');
INSERT INTO Ingredient (nom) VALUES ('Jus de papaye');
INSERT INTO Ingredient (nom) VALUES ('Jus de kiwi');
INSERT INTO Ingredient (nom) VALUES ('Jus de banane');
INSERT INTO Ingredient (nom) VALUES ('Jus de fraise');
INSERT INTO Ingredient (nom) VALUES ('Jus de framboise');
INSERT INTO Ingredient (nom) VALUES ('Jus de bleuet');
INSERT INTO Ingredient (nom) VALUES ('Jus de cassis');
INSERT INTO Ingredient (nom) VALUES ('Jus de litchi');
INSERT INTO Ingredient (nom) VALUES ('Jus de pêche');
INSERT INTO Ingredient (nom) VALUES ('Jus de poire');
INSERT INTO Ingredient (nom) VALUES ('Jus de melon');

-- Insertion des données dans la table Alcool
INSERT INTO Alcool (nom) VALUES ('Vodka');
INSERT INTO Alcool (nom) VALUES ('Tequila');
INSERT INTO Alcool (nom) VALUES ('Rhum');
INSERT INTO Alcool (nom) VALUES ('Whisky');
INSERT INTO Alcool (nom) VALUES ('Gin');
INSERT INTO Alcool (nom) VALUES ('Cognac');
INSERT INTO Alcool (nom) VALUES ('Bière');
INSERT INTO Alcool (nom) VALUES ('Vin');
INSERT INTO Alcool (nom) VALUES ('Champagne');
INSERT INTO Alcool (nom) VALUES ('Saké');
INSERT INTO Alcool (nom) VALUES ('Hydromel');
INSERT INTO Alcool (nom) VALUES ('Absinthe');
INSERT INTO Alcool (nom) VALUES ('Liqueur');
INSERT INTO Alcool (nom) VALUES ('Porto');
INSERT INTO Alcool (nom) VALUES ('Xérès');
INSERT INTO Alcool (nom) VALUES ('Vermouth');
INSERT INTO Alcool (nom) VALUES ('Scotch');
INSERT INTO Alcool (nom) VALUES ('Bourbon');
INSERT INTO Alcool (nom) VALUES ('Moonshine');
INSERT INTO Alcool (nom) VALUES ('Calvados');
INSERT INTO Alcool (nom) VALUES ('Armagnac');
INSERT INTO Alcool (nom) VALUES ('Eau-de-vie');
INSERT INTO Alcool (nom) VALUES ('Grappa');
INSERT INTO Alcool (nom) VALUES ('Ouzo');
INSERT INTO Alcool (nom) VALUES ('Schnaps');
INSERT INTO Alcool (nom) VALUES ('Aquavit');
INSERT INTO Alcool (nom) VALUES ('Mescal');
INSERT INTO Alcool (nom) VALUES ('Pisco');
INSERT INTO Alcool (nom) VALUES ('Cachaça');
INSERT INTO Alcool (nom) VALUES ('Soju');
INSERT INTO Alcool (nom) VALUES ('Raki');
INSERT INTO Alcool (nom) VALUES ('Pastis');
INSERT INTO Alcool (nom) VALUES ('Limoncello');
INSERT INTO Alcool (nom) VALUES ('Amaretto');
INSERT INTO Alcool (nom) VALUES ('Sambuca');
INSERT INTO Alcool (nom) VALUES ('Anisette');
INSERT INTO Alcool (nom) VALUES ('Triple Sec');
INSERT INTO Alcool (nom) VALUES ('Grand Marnier');
INSERT INTO Alcool (nom) VALUES ('Cointreau');
INSERT INTO Alcool (nom) VALUES ('Chartreuse');
INSERT INTO Alcool (nom) VALUES ('Baileys');
INSERT INTO Alcool (nom) VALUES ('Kahlúa');
INSERT INTO Alcool (nom) VALUES ('Jägermeister');
INSERT INTO Alcool (nom) VALUES ('Campari');
INSERT INTO Alcool (nom) VALUES ('Fernet');

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
/*
-- Insertion des données dans la table Ingredient
DELETE FROM Ingredient;
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
INSERT INTO Ingredient (nom) VALUES ('Jus de orange');
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
INSERT INTO Ingredient (nom) VALUES ('Jus de litchi');


-- Insertion des données dans la table Alcool
DELETE FROM Alcool;
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

*/
-- Suppression des données
DELETE FROM cocktail_liked;
DELETE FROM commentaire_liked;
DELETE FROM commentaire;
DELETE FROM ingredient_cocktail;
DELETE FROM cocktail;
DELETE FROM alcool_utilisateur;
DELETE FROM ingredient_utilisateur;
DELETE FROM utilisateur;
DELETE FROM banque_image;
DELETE FROM alcool;
DELETE FROM ingredient;


-- Insertion des données dans la table Ingredient
INSERT INTO Ingredient (nom) VALUES ('Sucre');
INSERT INTO Ingredient (nom) VALUES ('Citron');
INSERT INTO Ingredient (nom) VALUES ('Menthe');
INSERT INTO Ingredient (nom) VALUES ('Glace');

-- Insertion des données dans la table Alcool
INSERT INTO Alcool (nom, information, lien_saq) VALUES ('Vodka', 'Alcool fort', 'http://example.com/vodka');
INSERT INTO Alcool (nom, information, lien_saq) VALUES ('Rhum', 'Alcool des Caraïbes', 'http://example.com/rum');
INSERT INTO Alcool (nom, information, lien_saq) VALUES ('Gin', 'Spiritueux aromatisé au genièvre', 'http://example.com/gin');
INSERT INTO Alcool (nom, information, lien_saq) VALUES ('Tequila', 'Spiritueux mexicain', 'http://example.com/tequila');

-- Insertion des données dans la table Banque_Image
INSERT INTO Banque_Image (img, img_cocktail) VALUES ('BLOB_DATA', 1);
INSERT INTO Banque_Image (img, img_cocktail) VALUES ('BLOB_DATA', 0);

-- Insertion des données dans la table Utilisateur
INSERT INTO Utilisateur (nom, courriel, mdp_hashed, privilege, data_naiss, desc_public, id_image) VALUES ('John Doe', 'john@example.com', 'hashed_password', 0, '2000-01-01', 'J\'adore les cocktails', 1);
INSERT INTO Utilisateur (nom, courriel, mdp_hashed, privilege, data_naiss, desc_public, id_image) VALUES ('Jane Doe', 'jane@example.com', 'hashed_password', 0, '2000-01-02', 'J\'adore préparer des cocktails', 2);

-- Insertion des données dans la table Ingredient_Utilisateur
INSERT INTO Ingredient_Utilisateur (id_utilisateur, id_ingredient) VALUES (1, 1);
INSERT INTO Ingredient_Utilisateur (id_utilisateur, id_ingredient) VALUES (1, 2);
INSERT INTO Ingredient_Utilisateur (id_utilisateur, id_ingredient) VALUES (2, 3);
INSERT INTO Ingredient_Utilisateur (id_utilisateur, id_ingredient) VALUES (2, 4);

-- Insertion des données dans la table Alcool_utilisateur
INSERT INTO Alcool_utilisateur (id_utilisateur, id_alcool) VALUES (1, 1);
INSERT INTO Alcool_utilisateur (id_utilisateur, id_alcool) VALUES (1, 2);
INSERT INTO Alcool_utilisateur (id_utilisateur, id_alcool) VALUES (2, 3);
INSERT INTO Alcool_utilisateur (id_utilisateur, id_alcool) VALUES (2, 4);

-- Insertion des données dans la table Cocktail
INSERT INTO Cocktail (nom, desc_cocktail, preparation, nb_like, date_publication, type_verre, classique, profil_saveur, id_utilisateur, id_image, id_alcool) VALUES ('Mojito', 'Cocktail rafraîchissant', 'Mélanger tous les ingrédients', 0, '2022-01-01', 'Verre long', 1, 'Sucré', 1, 1, 2);
INSERT INTO Cocktail (nom, desc_cocktail, preparation, nb_like, date_publication, type_verre, classique, profil_saveur, id_utilisateur, id_image, id_alcool) VALUES ('Gin Tonic', 'Cocktail classique', 'Mélanger gin et tonic', 0, '2022-01-02', 'Verre long', 1, 'Amer', 2, 2, 3);

-- Insertion des données dans la table Ingredient_Cocktail
INSERT INTO Ingredient_Cocktail (quantite, unite, id_ingredient, id_cocktail) VALUES (1, 'pièce', 2, 1);
INSERT INTO Ingredient_Cocktail (quantite, unite, id_ingredient, id_cocktail) VALUES (2, 'cuillère', 1, 1);
INSERT INTO Ingredient_Cocktail (quantite, unite, id_ingredient, id_cocktail) VALUES (1, 'pièce', 3, 2);
INSERT INTO Ingredient_Cocktail (quantite, unite, id_ingredient, id_cocktail) VALUES (1, 'pièce', 4, 2);

-- Insertion des données dans la table Commentaire
INSERT INTO Commentaire (contenu, date_commentaire, nb_like, id_utilisateur, id_cocktail) VALUES ('Super cocktail !', '2022-01-02', 0, 1, 1);
INSERT INTO Commentaire (contenu, date_commentaire, nb_like, id_utilisateur, id_cocktail) VALUES ('J\'adore celui-ci !', '2022-01-03', 0, 2, 2);

-- Insertion des données dans la table Commentaire_Liked
INSERT INTO Commentaire_Liked (id_commentaire, id_utilisateur) VALUES (1, 1);
INSERT INTO Commentaire_Liked (id_commentaire, id_utilisateur) VALUES (2, 2);

-- Insertion des données dans la table Cocktail_Liked
INSERT INTO Cocktail_Liked (id_cocktail, id_utilisateur) VALUES (1, 1);
INSERT INTO Cocktail_Liked (id_cocktail, id_utilisateur) VALUES (2, 2);

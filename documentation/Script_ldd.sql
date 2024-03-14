-- ============================================================
-- Auteurs : Yani Amellal, Léonard Marcoux, Pablo Hamel-Corôa,
--           Maxime Dmitriev et Vianney Veremme
-- Date de création : 03-03-2024
-- Description :
--  Script de création des tables de la base donnée reliée
--  au site web cocktail wizard
--  Tables: Ingredient, Alcool, Ingredient_Utilisateur,
--  Utilisateur, Alcool_utilisateur, Commentaire, Banque_Image,
--  Ingredient_Cocktail, Cocktail, Commentaire_Liked, Cocktail_Liked.
--
-- ============================================================

-- Drop les tables avant la création si elle sont déja crée.
DROP TABLE IF EXISTS Cocktail_Liked CASCADE;
DROP TABLE IF EXISTS Commentaire_Liked CASCADE;
DROP TABLE IF EXISTS Commentaire CASCADE;
DROP TABLE IF EXISTS Ingredient_Cocktail CASCADE;
DROP TABLE IF EXISTS Cocktail CASCADE;
DROP TABLE IF EXISTS Alcool_utilisateur CASCADE;
DROP TABLE IF EXISTS Ingredient_Utilisateur CASCADE;
DROP TABLE IF EXISTS Utilisateur CASCADE;
DROP TABLE IF EXISTS Banque_Image CASCADE;
DROP TABLE IF EXISTS Ingredient CASCADE;
DROP TABLE IF EXISTS Alcool CASCADE;

-- Création de la table Ingredient
CREATE TABLE Ingredient (
    id_ingredient INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL UNIQUE
);

-- Création de la table Alcool
CREATE TABLE Alcool (
    id_alcool INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL UNIQUE,
    information VARCHAR(400),
    lien_saq VARCHAR(255),
    CONSTRAINT lien_saq_format CHECK (lien_saq LIKE 'http://%'
    OR lien_saq LIKE 'https://%' OR lien_saq IS NULL)
);

-- Création de la table Banque_Image
-- Essayer de stocker l'image avec des liens dans la base de donnée
CREATE TABLE Banque_Image (
    id_image INT PRIMARY KEY AUTO_INCREMENT,
    img VARCHAR(255) NOT NULL,
    -- Permet de savoir si l'image est utilisée pour un
    -- cocktail ou pour une image de profil.
    img_cocktail BOOLEAN NOT NULL,
    CONSTRAINT img_cocktail_boolean CHECK (img_cocktail IN (0, 1))
);

-- Création de la table Utilisateur
CREATE TABLE Utilisateur (
    id_utilisateur INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    courriel VARCHAR(255) NOT NULL UNIQUE,
    mdp_hashed VARCHAR(255) NOT NULL,
    privilege BOOLEAN NOT NULL,
    data_naiss Date NOT NULL,
    desc_public VARCHAR(2000),
    id_image INT,
    FOREIGN KEY (id_image) REFERENCES Banque_Image(id_image),
    CONSTRAINT privilege_boolean CHECK (privilege IN (0, 1)),
    CONSTRAINT courriel_format CHECK (courriel LIKE '%@%.%')
);

-- Création de la table Ingredient_Utilisateur
CREATE TABLE Ingredient_Utilisateur (
    id_utilisateur INT,
    id_ingredient INT,
    PRIMARY KEY (id_utilisateur, id_ingredient),
    FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur(id_utilisateur),
    FOREIGN KEY (id_ingredient) REFERENCES Ingredient(id_ingredient)
);

-- Création de la table Alcool_utilisateur
CREATE TABLE Alcool_utilisateur (
    id_utilisateur INT,
    id_alcool INT,
    PRIMARY KEY (id_utilisateur, id_alcool),
    FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur(id_utilisateur),
    FOREIGN KEY (id_alcool) REFERENCES Alcool(id_alcool)
);

-- Création de la table Cocktail
CREATE TABLE Cocktail (
    id_cocktail INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL,
    desc_cocktail VARCHAR(2000) NOT NULL,
    preparation VARCHAR(2000) NOT NULL,
    nb_like INT NOT NULL,
    date_publication Date NOT NULL,
    type_verre VARCHAR(255) NOT NULL,
    classique BOOLEAN NOT NULL,
    profil_saveur VARCHAR(255) NOT NULL,
    id_utilisateur INT NOT NULL,
    id_image INT,
    id_alcool INT,
    FOREIGN KEY (id_image) REFERENCES Banque_Image(id_image),
    FOREIGN KEY (id_alcool) REFERENCES Alcool(id_alcool),
    FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur(id_utilisateur),
    CONSTRAINT classique_boolean CHECK (classique IN (0, 1))
);

-- Création de la table Ingredient_Cocktail
CREATE TABLE Ingredient_Cocktail (
    id_ingredient_cocktail INT PRIMARY KEY AUTO_INCREMENT,
    quantite FLOAT NOT NULL,
    unite VARCHAR(100) NOT NULL,
    ingredient_autre VARCHAR(255),
    id_ingredient INT,
    id_alcool INT,
    id_cocktail INT NOT NULL,
    FOREIGN KEY (id_ingredient) REFERENCES Ingredient(id_ingredient),
    FOREIGN KEY (id_alcool) REFERENCES Alcool(id_alcool),
    FOREIGN KEY (id_cocktail) REFERENCES Cocktail(id_cocktail),
    -- Permet d'avoir un seul type d'ingrédient par ligne
    CONSTRAINT ingredient_unique CHECK(
        (id_ingredient IS NOT NULL AND id_alcool IS NULL AND ingredient_autre IS NULL) OR
        (id_ingredient IS NULL AND id_alcool IS NOT NULL AND ingredient_autre IS NULL) OR
        (id_ingredient IS NULL AND id_alcool IS NULL AND ingredient_autre IS NOT NULL))
);

-- Création de la table Commentaire
CREATE TABLE Commentaire (
    id_commentaire INT PRIMARY KEY AUTO_INCREMENT,
    contenu VARCHAR(2000) NOT NULL,
    date_commentaire Date NOT NULL,
    nb_like INT NOT NULL,
    id_utilisateur INT NOT NULL,
    id_cocktail INT NOT NULL,
    FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur(id_utilisateur),
    FOREIGN KEY (id_cocktail) REFERENCES Cocktail(id_cocktail)
);

-- Création de la table Commentaire_Liked
CREATE TABLE Commentaire_Liked (
    id_commentaire INT,
    id_utilisateur INT,
    PRIMARY KEY (id_commentaire, id_utilisateur),
    FOREIGN KEY (id_commentaire) REFERENCES Commentaire(id_commentaire),
    FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur(id_utilisateur)
);

-- Création de la table Cocktail_Liked
CREATE TABLE Cocktail_Liked (
    id_cocktail INT,
    id_utilisateur INT,
    PRIMARY KEY (id_cocktail, id_utilisateur),
    FOREIGN KEY (id_cocktail) REFERENCES Cocktail(id_cocktail),
    FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur(id_utilisateur)
);

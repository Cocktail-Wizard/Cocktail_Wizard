-- ============================================================
-- Auteurs : Yani Amellal, Léonard Marcoux, Pablo Hamel-Corôa,
--           Maxime Dmitriev et Vianney Veremme
-- Date de création : 03-03-2024
-- Description :
--  Script de création des tables de la base donnée reliée
--  au site web cocktail wizard
--  Tables: Ingredient, Alcool, Ingredient_Utilisateur,
--  Utilisateur, Alcool_utilisateur, Commentaire, Banque_Image,
--  Ingredient_Cocktail, Cocktail.
--
-- ============================================================

-- Drop les tables avant la création si elle sont déja crée.
DROP TABLE IF EXISTS Commentaire CASCADE;
DROP TABLE IF EXISTS Ingredient_Utilisateur CASCADE;
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
    nom VARCHAR(255) NOT NULL
);

-- Création de la table Alcool
CREATE TABLE Alcool (
    id_alcool INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL,
    information VARCHAR(255),
    lien_saq VARCHAR(255)
);

-- Création de la table Banque_Image
CREATE TABLE Banque_Image (
    id_image INT PRIMARY KEY AUTO_INCREMENT,
    img LONGBLOB NOT NULL,
    img_cocktail BIT NOT NULL
);

-- Création de la table Utilisateur
CREATE TABLE Utilisateur (
    id_utilisateur INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    courriel VARCHAR(255) NOT NULL,
    mdp VARCHAR(255) NOT NULL,
    privilege BIT NOT NULL,
    data_naiss Date NOT NULL,
    desc_public VARCHAR(2000),
    id_image INT,
    FOREIGN KEY (id_image) REFERENCES Banque_Image(id_image)
);

-- Création de la table Ingredient_Utilisateur
CREATE TABLE Ingredient_Utilisateur (
    id_utilisateur INT,
    id_ingredient INT,
    PRIMARY KEY (id_utilisateur, id_ingredient),
    FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur(id_utilisateur)
);



-- Création de la table Alcool_utilisateur
CREATE TABLE Alcool_utilisateur (
    id_utilisateur INT,
    id_alcool INT,
    PRIMARY KEY (id_utilisateur, id_alcool),
    FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur(id_utilisateur)
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
    classique BIT NOT NULL,
    profil_saveur VARCHAR(255) NOT NULL,
    id_image INT,
    id_alcool INT,
    FOREIGN KEY (id_image) REFERENCES Banque_Image(id_image),
    FOREIGN KEY (id_alcool) REFERENCES Alcool(id_alcool)
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
    FOREIGN KEY (id_cocktail) REFERENCES Cocktail(id_cocktail)
);

-- Création de la table Commentaire
CREATE TABLE Commentaire (
    id_commentaire INT PRIMARY KEY AUTO_INCREMENT,
    contenu VARCHAR(2000) NOT NULL,
    date_commentaire Date NOT NULL,
    nb_like INT NOT NULL,
    id_utilisateur INT,
    id_cocktail INT,
    FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur(id_utilisateur),
    FOREIGN KEY (id_cocktail) REFERENCES Cocktail(id_cocktail)
);

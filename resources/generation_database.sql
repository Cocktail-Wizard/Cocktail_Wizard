-- Suppression des tables si elles existent déjà
DROP TABLE IF EXISTS Publications;
DROP TABLE IF EXISTS Commentaires;
DROP TABLE IF EXISTS Utilisateurs;
DROP TABLE IF EXISTS Cocktails;
DROP TABLE IF EXISTS Pays;
DROP TABLE IF EXISTS Alcools;

-- Création des tables
CREATE TABLE Publications (
    Titre VARCHAR(50) PRIMARY KEY,
    Auteur VARCHAR(50),
    Date_de_publication DATE,
    Likes INT,
    Illustration BLOB,
    Cocktail VARCHAR(50),
    FOREIGN KEY (Cocktail) REFERENCES Cocktails(Nom)
);

CREATE TABLE Commentaires (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Message TEXT,
    Auteur VARCHAR(50),
    Note INT,
    FOREIGN KEY (Auteur) REFERENCES Utilisateurs(Pseudo)
);

CREATE TABLE Utilisateurs (
    Pseudo VARCHAR(50) PRIMARY KEY,
    Publications INT,
    Likes INT,
    Nom VARCHAR(50),
    Prenom VARCHAR(50),
    Courriel VARCHAR(100),
    Pays VARCHAR(50),
    Mot_de_passe VARCHAR(100),
    FOREIGN KEY (Pays) REFERENCES Pays(Nom)
);


CREATE TABLE Cocktails (
    Nom VARCHAR(50) PRIMARY KEY,
    Description TEXT,
    Origine VARCHAR(100),
    Umami BOOLEAN,
    Alcool_principal VARCHAR(50),
    Preparation TEXT,
    Verre_de_service VARCHAR(20),
    Status INT,
    FOREIGN KEY (Origine) REFERENCES Pays(Nom)
);


CREATE TABLE Pays (
    Nom VARCHAR(50) PRIMARY KEY,
    Region VARCHAR(50)
);

CREATE TABLE Alcools (
    Nom VARCHAR(100) PRIMARY KEY,
    Description TEXT,
    Classification INT
);

-- ============================================================
-- Auteurs : Yani Amellal, Léonard Marcoux, Pablo Hamel-Corôa,
--           Maxime Dmitriev et Vianney Veremme
-- Date de création : 03-03-2024
-- Description :
--  Script de création des triggers pour la base donnée reliée
--  au site web cocktail wizard
-- Triggers :
--
-- ============================================================

-- Affiche les triggers
SHOW TRIGGERS;

DELIMITER // -- Permet de changer le délimiteur pour le trigger

--
-- DECLENCHEUR: TRG_date_publication_non_update
-- TABLE: Cocktail
-- TYPE: Avant requête de mise à jour
-- DESCRIPTION:
--  Empêche la modification de la date de publication
-- d'un cocktail
-- *Vérifier si nécessaire
--
DROP TRIGGER IF EXISTS TRG_date_publication_non_update;
CREATE TRIGGER TRG_date_publication_non_update
BEFORE UPDATE ON Cocktail
FOR EACH ROW
BEGIN
    IF NEW.date_publication != OLD.date_publication THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'La date de publication ne peut pas être modifiée';
    END IF;
END//

--
-- DECLENCHEUR: TRG_date_commentaire_non_update
-- TABLE: Commentaire
-- TYPE: Avant requête de mise à jour
-- DESCRIPTION:
--  Empêche la modification de la date de publication
--  d'un commentaire
-- *Vérifier si nécessaire
--
DROP TRIGGER IF EXISTS TRG_date_commentaire_non_update;
CREATE TRIGGER TRG_date_commentaire_non_update
BEFORE UPDATE ON Commentaire
FOR EACH ROW
BEGIN
    IF NEW.date_commentaire != OLD.date_commentaire THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'La date de publication ne peut pas être modifiée';
    END IF;
END//

--
-- DECLENCHEUR: TRG_nb_like_cocktail_+
-- TABLE: Cocktail_Liked
-- TYPE: Après requête d'insertion
-- DESCRIPTION:
--  Incrémente le nombre de like d'un cocktail
--
DROP TRIGGER IF EXISTS TRG_nb_like_cocktail_plus;
CREATE TRIGGER TRG_nb_like_cocktail_plus
AFTER INSERT ON Cocktail_Liked
FOR EACH ROW
BEGIN
    UPDATE Cocktail
    SET nb_like = nb_like + 1
    WHERE id_cocktail = NEW.id_cocktail;
END//

--
-- DECLENCHEUR: TRG_nb_like_commentaire_+
-- TABLE: Commentaire_Liked
-- TYPE: Après requête d'insertion
-- DESCRIPTION:
--  Incrémente le nombre de like d'un commentaire
--
DROP TRIGGER IF EXISTS TRG_nb_like_commentaire_plus;
CREATE TRIGGER TRG_nb_like_commentaire_plus
AFTER INSERT ON Commentaire_Liked
FOR EACH ROW
BEGIN
    UPDATE Commentaire
    SET nb_like = nb_like + 1
    WHERE id_commentaire = NEW.id_commentaire;
END//

--
-- DECLENCHEUR: TRG_nb_like_cocktail_-
-- TABLE: Cocktail_Liked
-- TYPE: Après requête de suppression
-- DESCRIPTION:
--  Décrémente le nombre de like d'un cocktail
--
DROP TRIGGER IF EXISTS TRG_nb_like_cocktail_moins;
CREATE TRIGGER TRG_nb_like_cocktail_moins
AFTER DELETE ON Cocktail_Liked
FOR EACH ROW
BEGIN
    UPDATE Cocktail
    SET nb_like = nb_like - 1
    WHERE id_cocktail = OLD.id_cocktail;
END//

--
-- DECLENCHEUR: TRG_nb_like_commentaire_-
-- TABLE: Commentaire_Liked
-- TYPE: Après requête de suppression
-- DESCRIPTION:
--  Décrémente le nombre de like d'un commentaire
--
DROP TRIGGER IF EXISTS TRG_nb_like_commentaire_moins;
CREATE TRIGGER TRG_nb_like_commentaire_moins
AFTER DELETE ON Commentaire_Liked
FOR EACH ROW
BEGIN
    UPDATE Commentaire
    SET nb_like = nb_like - 1
    WHERE id_commentaire = OLD.id_commentaire;
END//



DELIMITER ;

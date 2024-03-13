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

/*
--
-- DECLENCHEUR: TRG_lien_saq
-- TABLE: Alcool
-- TYPE: Avant requête d'insertion ou de mise à jour
-- DESCRIPTION:
--  Vérifie si le lien saq est valide
-- TODO : Essayer d'utiliser une expression régulière pour valider le lien (REGEXP)
--
DELIMITER // -- Permet de changer le délimiteur pour le trigger
DROP TRIGGER IF EXISTS TRG_lien_saq_update;
CREATE TRIGGER TRG_lien_saq_update
BEFORE UPDATE ON Alcool
FOR EACH ROW
BEGIN
    IF NEW.lien_saq IS NOT NULL AND
       (NEW.lien_saq NOT LIKE 'http://%' AND NEW.lien_saq NOT LIKE 'https://%') THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Le lien SAQ n''est pas valide';
    END IF;
END//
DROP TRIGGER IF EXISTS TRG_lien_saq_insert;
CREATE TRIGGER TRG_lien_saq_insert
BEFORE INSERT ON Alcool
FOR EACH ROW
BEGIN
    IF NEW.lien_saq IS NOT NULL AND
       (NEW.lien_saq NOT LIKE 'http://%' AND NEW.lien_saq NOT LIKE 'https://%') THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Le lien SAQ n''est pas valide';
    END IF;
END//
DELIMITER ;
*/

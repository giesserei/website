--
-- Neue Spalten für Tabelle #__mgh_mitglied
--
ALTER TABLE joomghjos_mgh_mitglied ADD COLUMN dispension_grad DECIMAL(5,2) NOT NULL DEFAULT 0 COMMENT 'Grad der Dispensierung in der Zeitbank';
ALTER TABLE joomghjos_mgh_mitglied ADD COLUMN kommentar varchar(500);

--
-- Neue Spalten für Tabelle #__mgh_mitglied_history
--
ALTER TABLE joomghjos_mgh_mitglied_history ADD COLUMN dispension_grad DECIMAL(5,2) NOT NULL DEFAULT 0;
ALTER TABLE joomghjos_mgh_mitglied_history ADD COLUMN kommentar varchar(500);
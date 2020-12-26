--
-- Neue Spalte für Tabelle #__mgh_mietobjekt
--
ALTER TABLE joomghjos_mgh_mietobjekt ADD COLUMN kz_frei CHAR(1) NOT NULL DEFAULT '0' COMMENT 'Flag';
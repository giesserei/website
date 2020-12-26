--
-- Neue Spalten für Tabelle #__mgh_mitglied
--
ALTER TABLE joomghjos_mgh_mitglied ADD COLUMN zb_ausbildung_bis DATE NOT NULL DEFAULT '0000-00-00';

--
-- Neue Spalten für Tabelle #__mgh_mitglied_history
--
ALTER TABLE joomghjos_mgh_mitglied_history ADD COLUMN zb_ausbildung_bis DATE NOT NULL DEFAULT '0000-00-00';
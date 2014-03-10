--
-- Neue Spalten für Tabelle #__mgh_mitglied
--
ALTER TABLE joomghjos_mgh_mitglied ADD COLUMN zb_freistellung SMALLINT NOT NULL DEFAULT 0 COMMENT 'Anzahl der Freistellungsmonate in der Zeitbank (z.B. Einzug)';

--
-- Neue Spalten für Tabelle #__mgh_mitglied_history
--
ALTER TABLE joomghjos_mgh_mitglied_history ADD COLUMN zb_freistellung SMALLINT NOT NULL DEFAULT 0;
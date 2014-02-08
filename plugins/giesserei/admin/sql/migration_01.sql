--
-- Neue Spalten für Tabelle #__mgh_mitglied
--
ALTER TABLE joomghjos_mgh_mitglied ADD COLUMN einzug DATE NOT NULL DEFAULT '0000-00-00';
ALTER TABLE joomghjos_mgh_mitglied ADD COLUMN typ SMALLINT NOT NULL DEFAULT 1;
ALTER TABLE joomghjos_mgh_mitglied ADD COLUMN update_userid bigint(20) NULL;
ALTER TABLE joomghjos_mgh_mitglied ADD COLUMN update_timestamp DATETIME NULL;

CREATE TABLE IF NOT EXISTS `joomghjos_mgh_mitglied_history` (
  `id_hist` bigint(20) NOT NULL AUTO_INCREMENT,
  `id` bigint(20) NOT NULL,
  `userid` bigint(20) NOT NULL,
  `vorname` varchar(40) NOT NULL,
  `nachname` varchar(50) NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `plz` varchar(10) NOT NULL,
  `ort` varchar(40) NOT NULL,
  `telefon` varchar(18) NOT NULL,
  `telefon_frei` char(1) NOT NULL DEFAULT '0',
  `handy` varchar(18) NOT NULL,
  `handy_frei` char(1) NOT NULL DEFAULT '0',
  `jahrgang` varchar(5) NOT NULL,
  `zur_person` text NOT NULL,
  `funktion` varchar(50) NOT NULL,
  `eintritt` date NOT NULL,
  `austritt` date NOT NULL,
   einzug DATE NOT NULL,
   typ SMALLINT NOT NULL DEFAULT 1,
   update_userid bigint(20) NULL,
   update_timestamp DATETIME NULL,
   PRIMARY KEY (`id_hist`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
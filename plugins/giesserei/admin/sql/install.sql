-- phpMyAdmin SQL Dump
-- version 4.0.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 26. Okt 2013 um 07:57
-- Server Version: 5.5.33-MariaDB
-- PHP-Version: 5.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Datenbank: `mgh_joomla_2013`
--

--
--  Angepasst für neuen Giesserei-Server auf HostEurope, Jürg Altwegg
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `#__mgh_bereich`
--

CREATE TABLE IF NOT EXISTS `#__mgh_bereich` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `grp_id` bigint(20) NOT NULL COMMENT 'Relation zur Joomla-Usergruppe',
  `leitung_userid` bigint(20) NOT NULL COMMENT 'Leitung: Relation zur Joomla-Usertabelle',
  `ordering` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Arbeitsgruppen, Bereiche und Kommissionen' AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `#__mgh_kind`
--

CREATE TABLE IF NOT EXISTS `#__mgh_kind` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `vorname` varchar(50) NOT NULL,
  `name_frei` char(1) NOT NULL DEFAULT '1' COMMENT 'Flag: Name freigegeben',
  `nachname` varchar(50) NOT NULL,
  `jahrgang` varchar(5) NOT NULL,
  `jahrgang_frei` char(1) NOT NULL DEFAULT '0' COMMENT 'Flag: Jahrgang freigegeben',
  `handy` varchar(18) NOT NULL,
  `handy_frei` char(1) NOT NULL DEFAULT '0' COMMENT 'Flag: Handy freigegeben',
  `objektid` bigint(20) NOT NULL COMMENT 'Relation zur Wohnung',
  PRIMARY KEY (`id`),
  KEY `jahrgang` (`jahrgang`,`objektid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=74 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `#__mgh_mietobjekt`
--

CREATE TABLE IF NOT EXISTS `#__mgh_mietobjekt` (
  `id` int(11) NOT NULL COMMENT 'Giesserei-Wohungsnummer',
  `typid` bigint(20) NOT NULL COMMENT 'Relation zu den Typen',
  `miete` int(11) NOT NULL COMMENT 'In Franken',
  `subventioniert` int(11) NOT NULL DEFAULT '0' COMMENT 'allenfalls subventionierte Miete',
  `nk` int(11) NOT NULL COMMENT 'Nebenkosten Akonto',
  `nk_stadtwerk` int(11) NOT NULL COMMENT 'Prognose Stadtwerk-NK',
  `pflichtdarlehen` int(11) NOT NULL COMMENT 'In Franken',
  `flaeche` int(11) NOT NULL COMMENT 'in Quadratmetern',
  `maisonette` char(1) NOT NULL DEFAULT '0' COMMENT 'Flag',
  `grundriss` varchar(30) NOT NULL COMMENT 'Pfad zum Bild',
  `anmerkung` varchar(100) NOT NULL,
  `freiab` date NOT NULL COMMENT 'Wohnung wird wieder frei ab',
  `nasszellen` int(11) NOT NULL COMMENT 'Anzahl Nasszellen',
  `reduit` int(11) NOT NULL COMMENT 'Anzahl Reduits',
  `mietvertrag_beginn` date NOT NULL,
  `gewerbe_flaeche` int(11) NOT NULL DEFAULT '0',
  `oto` varchar(20) NOT NULL COMMENT 'OTO-ID des Glasfaseranschluesses',
  PRIMARY KEY (`id`),
  KEY `typid` (`typid`),
  KEY `gewerbe_flaeche` (`gewerbe_flaeche`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `#__mgh_mitglied`
--

CREATE TABLE IF NOT EXISTS `#__mgh_mitglied` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` bigint(20) NOT NULL COMMENT 'Relation zur Joomla-User-ID',
  `vorname` varchar(40) NOT NULL,
  `nachname` varchar(50) NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `plz` varchar(10) NOT NULL COMMENT 'Postleitzahl',
  `ort` varchar(40) NOT NULL,
  `telefon` varchar(18) NOT NULL,
  `telefon_frei` char(1) NOT NULL DEFAULT '0' COMMENT 'Freigabeflag',
  `handy` varchar(18) NOT NULL,
  `handy_frei` char(1) NOT NULL DEFAULT '0' COMMENT 'Freigabeflag',
  `jahrgang` varchar(5) NOT NULL COMMENT 'nur Jahrgang für Statistik',
  `zur_person` text NOT NULL COMMENT 'Porträttext',
  `funktion` varchar(50) NOT NULL COMMENT 'Vereinsfunktions (z.B. Aktuarin)',
  `eintritt` date NOT NULL COMMENT 'Vereinsbeitritt',
  `austritt` date NOT NULL COMMENT 'Vereinsaustritt',
  PRIMARY KEY (`id`),
  KEY `nachname` (`nachname`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=220 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `#__mgh_mitgliederjournal`
--

CREATE TABLE IF NOT EXISTS `#__mgh_mitgliederjournal` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` bigint(20) NOT NULL COMMENT 'Relation zu User',
  `datum` date NOT NULL,
  `klasseid` bigint(20) NOT NULL COMMENT 'Relation zur Klasse',
  `beschreibung` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`,`datum`,`klasseid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Journal über alle Mitglieder' AUTO_INCREMENT=55 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `#__mgh_mjournalklasse`
--

CREATE TABLE IF NOT EXISTS `#__mgh_mjournalklasse` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL COMMENT 'Erkennungsstring (menschenlesbare ID)',
  `text` varchar(100) NOT NULL,
  `farbe` varchar(6) NOT NULL COMMENT 'RGB-Farbcode',
  PRIMARY KEY (`id`),
  KEY `code` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Klassen (Kategorien) für das Mitgliederjournal' AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `#__mgh_objektjournal`
--

CREATE TABLE IF NOT EXISTS `#__mgh_objektjournal` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `objektid` bigint(20) NOT NULL COMMENT 'Relation zu Mietobjekt',
  `datum` date NOT NULL,
  `klasseid` bigint(20) NOT NULL COMMENT 'Relation zur Klasse',
  `titel` varchar(40) NOT NULL COMMENT 'Titel des Eintrags',
  `beschreibung` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`objektid`,`datum`,`klasseid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Journal über alle Mietobjekte' AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `#__mgh_objektoption`
--

CREATE TABLE IF NOT EXISTS `#__mgh_objektoption` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `beschreibung` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `#__mgh_objekttyp`
--

CREATE TABLE IF NOT EXISTS `#__mgh_objekttyp` (
  `id` bigint(20) NOT NULL,
  `bezeichnung` varchar(40) NOT NULL,
  `zimmerbezeichnung` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `#__mgh_ojournalklasse`
--

CREATE TABLE IF NOT EXISTS `#__mgh_ojournalklasse` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL COMMENT 'Erkennungsstring (menschenlesbare ID)',
  `text` varchar(100) NOT NULL,
  `farbe` varchar(6) NOT NULL COMMENT 'RGB-Farbcode',
  PRIMARY KEY (`id`),
  KEY `code` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Klassen (Kategorien) für das Mitgliederjournal' AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `#__mgh_x_mitglied_mietobjekt`
--

CREATE TABLE IF NOT EXISTS `#__mgh_x_mitglied_mietobjekt` (
  `userid` bigint(20) NOT NULL COMMENT 'Realtion zu Joomla-User',
  `objektid` bigint(20) NOT NULL COMMENT 'Realtion ui Mietobjekt',
  PRIMARY KEY (`userid`,`objektid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `#__mgh_x_obj_option`
--

CREATE TABLE IF NOT EXISTS `#__mgh_x_obj_option` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `objektid` int(11) NOT NULL,
  `optid` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `objektid` (`objektid`,`optid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=295 ;


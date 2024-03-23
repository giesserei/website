-- Umstellung der Datums-Feld-Werte von 0000-00-00 auf NULL.

-- Tabelle mgh_mitglied
set sql_mode = '';
alter table joomghjos_mgh_mitglied
   modify column eintritt          date,
   modify column austritt          date,
   modify column einzug            date,
   modify column zb_ausbildung_bis date;
set sql_mode = ''; update joomghjos_mgh_mitglied set eintritt          = null where eintritt          = '0000-00-00';    -- 17
set sql_mode = ''; update joomghjos_mgh_mitglied set austritt          = null where austritt          = '0000-00-00';    -- 336
set sql_mode = ''; update joomghjos_mgh_mitglied set einzug            = null where einzug            = '0000-00-00';    -- 53
set sql_mode = ''; update joomghjos_mgh_mitglied set zb_ausbildung_bis = null where zb_ausbildung_bis = '0000-00-00';    -- 337

-- Tabelle mgh_mitglied_history
set sql_mode = '';
alter table joomghjos_mgh_mitglied_history
   modify column eintritt          date,
   modify column austritt          date,
   modify column einzug            date,
   modify column zb_ausbildung_bis date;
set sql_mode = ''; update joomghjos_mgh_mitglied_history set eintritt          = null where eintritt          = '0000-00-00';
set sql_mode = ''; update joomghjos_mgh_mitglied_history set austritt          = null where austritt          = '0000-00-00';
set sql_mode = ''; update joomghjos_mgh_mitglied_history set einzug            = null where einzug            = '0000-00-00';
set sql_mode = ''; update joomghjos_mgh_mitglied_history set zb_ausbildung_bis = null where zb_ausbildung_bis = '0000-00-00';

-- Tabelle mgh_mietobjekt
set sql_mode = '';
alter table joomghjos_mgh_mietobjekt
   modify column freiab             date,
   modify column mietvertrag_beginn date;
set sql_mode = ''; update joomghjos_mgh_mietobjekt set freiab             = null where freiab             = '0000-00-00'; -- 161
set sql_mode = ''; update joomghjos_mgh_mietobjekt set mietvertrag_beginn = null where mietvertrag_beginn = '0000-00-00'; -- 39

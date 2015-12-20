<?php
defined('_JEXEC') or die('Restricted access');

class GiessereiModelWohnungsliste extends JModelLegacy
{

    /**
     * Erzeugt eine Liste mit allen Wohnungen
     */
    function getWohnungen()
    {
        $db = JFactory::getDBO();
        $query = "SELECT a.*, a.id as nummer, b.bezeichnung, b.zimmerbezeichnung, coalesce(c.anzahl_mitglieder, 0) as anzahl_mitglieder
                FROM #__mgh_mietobjekt a
                   INNER join #__mgh_objekttyp b on a.typid = b.id
                   LEFT JOIN (SELECT objektid, COUNT(*) as anzahl_mitglieder FROM #__mgh_x_mitglied_mietobjekt GROUP BY objektid) c ON a.id = c.objektid
                ORDER BY nummer";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        return ($rows);
    }

}

<?php
defined('_JEXEC') or die('Restricted access');

/**
 * Modell-Klasse für die Seite "Bewohnerliste".
 *
 * Changes:
 * - Nur Mitglieder berücksichtigen, denen eine Wohnung zugewiesen ist (SF, 2013-12-31)
 * - Wohnungen ohne Bewohner werden in der Bewohnerliste nicht gezeigt (SF, 2013-12-31)
 * - Bewohner, die bereits ausgezogen (Austrittsdatum gesetzt und in Vergangenheit) sind,
 *   denen aber noch eine Wohnung zugewiesen ist, werden nicht angezeigt (SF, 2014-02-06)
 */
class GiessereiModelHausliste extends JModelLegacy
{

    /**
     * Erzeugt eine Liste mit allen bewohnten Einheiten und deren Bewohnern.
     * Sind einem Bewohner mehrere Wohnungen zugewiesen, so ist dieser Bewohner mehrfach in der Liste enthalten,
     * wenn die Wohnungen sich in verschiedenen Häusern befinden.
     *
     * Der Hausverein, welcher auch Objekte gemietet hat (Gästezimmer), wird nicht aufgelistet.
     * Auch das Gewerbe wird nicht aufgelistet.
     */
    public function getBelegung()
    {
        $db = JFactory::getDBO();
        $query = "SELECT * FROM #__mgh_mitglied as mgl
	    		    JOIN #__mgh_x_mitglied_mietobjekt AS xmo ON mgl.userid = xmo.userid 
              WHERE (mgl.austritt >= NOW() OR mgl.austritt = '0000-00-00') AND mgl.typ IN (1)
				      ORDER BY objektid";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        return ($rows);
    }
}

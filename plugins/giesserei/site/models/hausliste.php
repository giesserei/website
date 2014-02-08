<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

/**
 * Modell-Klasse für die Seite "Bewohnerliste".
 * 
 * Changes:
 * - Nur Mitglieder berücksichtigen, denen eine Wohnung zugewiesen ist (SF, 2013-12-31)
 * - Wohnungen ohne Bewohner werden in der Bewohnerliste nicht gezeigt (SF, 2013-12-31)
 * - Bewohner, die bereits ausgezogen sind, denen aber noch eine Wohnung zugewiesen ist, 
 *   werden nicht angezeigt (SF, 2014-02-06)
 * 
 * @author JAL
 */
class GiessereiModelHausliste extends JModel {
  
  /**
   * Erzeugt eine Liste mit allen bewohnten Einheiten und deren Bewohnern/Gewerbe.
   * Sind einem Bewohner mehrere Wohnungen zugewiesen, so ist dieser Bewohner mehrfach in der Liste enthalten,
   * wenn die Wohnungen sich in verschiedenen Häusern befinden.
   */ 
  function getBelegung() {
    $db = & JFactory::getDBO();
    $query = "SELECT * FROM #__mgh_mitglied as mgl
	    		    JOIN #__mgh_x_mitglied_mietobjekt AS xmo ON mgl.userid = xmo.userid 
              WHERE (mgl.austritt >= NOW() OR mgl.austritt = '0000-00-00')
				      ORDER BY objektid";
    $db->setQuery($query);
    $rows = $db->loadObjectList();
    return ($rows);
  }
}
?>

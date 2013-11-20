<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class GiessereiModelHausliste extends JModel {

	// Erzeugt eine Liste mit allen bewohnten Einheiten und deren Mitgliedern
	function getBelegung( ) {
	    $db =& JFactory::getDBO();
	    $query = "SELECT * FROM #__mgh_mitglied as mgl
	    		LEFT JOIN #__mgh_x_mitglied_mietobjekt AS xmo ON mgl.userid = xmo.userid 
				ORDER BY objektid";
	    $db->setQuery($query);
	    $rows = $db->loadObjectList();
	    return($rows);
	} // end getReservation
	
}
?>

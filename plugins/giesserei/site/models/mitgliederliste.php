<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

/**
 * Modellklasse für die Mitgliederliste.
 */
class GiessereiModelMitgliederliste extends JModel {
	
	/**
	 * Liefert die Liste aller aktiven Mitglieder zurück (Bewohner, Gewerbe, Passivmitglieder).
	 */
	function getMitglieder() {
	    $db =& JFactory::getDBO();
	    $query = "SELECT *,usr.email as email, mgl.userid as userid FROM #__mgh_mitglied as mgl
	    	LEFT JOIN #__users AS usr ON mgl.userid = usr.id
	    	LEFT JOIN #__kunena_users AS kun ON mgl.userid = kun.userid
	    	WHERE (austritt>=NOW() OR austritt='0000-00-00') AND mgl.typ IN (1,2,3) ORDER BY nachname";
	    $db->setQuery($query);
	    $rows = $db->loadObjectList();
	    return($rows);
	} 

	/**
	 * Erzeugt Liste mit allen Mietobjekten eines bestimmten Mitglieds
	 */
	function getObjekte($userid) {
	    $db =& JFactory::getDBO();
	    $query = "SELECT * FROM #__mgh_x_mitglied_mietobjekt WHERE userid=".$userid;
	    $db->setQuery($query);
	    $rows = $db->loadObjectList();
	    return($rows);		
	} 
	
	/**
	 * Erzeugt Liste mit allen Kindern eines bestimmten Mietobjekts
	 */
	function getKinder( $objektid ) {
	    $db =& JFactory::getDBO();
	    $query = "SELECT * FROM #__mgh_kind WHERE objektid=".$objektid." ORDER BY vorname";
	    $db->setQuery($query);
	    $rows = $db->loadObjectList();
	    return($rows);
	} 
	
}
?>

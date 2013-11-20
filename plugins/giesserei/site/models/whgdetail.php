<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class GiessereiModelWhgDetail extends JModel {

	// Liest die Details einer bestimmten Wohnung ein
	function getWohnung($whgnr) {
    	$db =& JFactory::getDBO();
    	$query = 'SELECT *,mob.id as nummer FROM #__mgh_objekttyp as typ, #__mgh_mietobjekt as mob
    			LEFT JOIN #__mgh_x_mitglied_mietobjekt AS xmo ON mob.id = xmo.objektid  
    			LEFT JOIN #__users as usr ON xmo.userid = usr.id
				WHERE mob.typid = typ.id AND mob.id='.$whgnr;

    	$db->setQuery($query);
    	$rows = $db->loadObjectList();
    	return($rows);
	} // getWohnung
  
	// liest alle Optionen einer Wohnung 
	function getOptions( $whgnr ) {
	    $db =& JFactory::getDBO();
	    $query = "SELECT beschreibung FROM #__mgh_objektoption as opt,#__mgh_x_obj_option
	    			WHERE objektid = '".$whgnr."' AND optid = opt.id";

	    $db->setQuery($query);
	    $rows = $db->loadObjectList();
	    return($rows);
	} // end getOptions
}
?>

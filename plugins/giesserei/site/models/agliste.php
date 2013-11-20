<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class GiessereiModelAGListe extends JModel {
	
  // Erzeugt eine Liste mit als den Bereichen/Arbeitsgruppen zugeordneten Joomla-Usergruppen 
  function getGruppen() {
    $db =& JFactory::getDBO();
    $query = "SELECT * FROM #__mgh_bereich AS mbe 
    		LEFT JOIN #__usergroups AS ug ON mbe.grp_id = ug.id
    		ORDER BY ordering";
    $db->setQuery($query);
    $rows = $db->loadObjectList();
    return($rows);
  }

  // Erzeugt Liste mit allen Mitgliedern; Mitglieder müssen zwingend auch Joomla-Benutzer sein 
  function getMitglieder( $ag ) {
    $db =& JFactory::getDBO();
    $query = "SELECT * FROM #__mgh_mitglied AS mgl
    			LEFT JOIN #__users AS usr ON mgl.userid = usr.id
    			LEFT JOIN #__user_usergroup_map AS xug ON mgl.userid = xug.user_id  
    			WHERE xug.group_id =".$ag->id." ORDER BY nachname ASC";
    $db->setQuery($query);
    $rows = $db->loadObjectList();
    return($rows);
  }
  
}

?>

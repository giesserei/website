<?php
defined('_JEXEC') or die('Restricted access');

class GiessereiModelMitglied extends JModelLegacy
{

    /**
     * Liest ein bestimmtes Mitglied aus der Liste mit allen Details; Mitglieder müssen zwingend auch Joomla-Benutzer sein
     */
    public function getMitglied($userid)
    {
        $db = JFactory::getDBO();
        $query = 'SELECT *,usr.email as email, mgl.userid as userid FROM #__mgh_mitglied as mgl
		    	LEFT JOIN #__users AS usr ON mgl.userid = usr.id
		    	LEFT JOIN #__kunena_users AS kun ON mgl.userid = kun.userid
		    	WHERE mgl.userid=' . $userid;
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        return ($rows);
    }
}

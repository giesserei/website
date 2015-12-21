<?php
/*
 * Oktober 2013, JAL
 *
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modellist');

class GiessereiModelOJournalClasses extends JModelList
{

    protected function getListQuery()
    {
        $db = $this->getDBO();
        $query = $db->getQuery(true);

        $query->select('*');
        $query->from('#__mgh_ojournalklasse');
        $query->order('code ASC');

        return $query;
    }

}

?>

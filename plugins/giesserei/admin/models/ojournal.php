<?php
/*
 * Oktober 2013, JAL
 * 
 */
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modeladmin');

class GiessereiModelOJournal extends JModelAdmin
{

    public function getTable($type = "OJournals", $prefix = "GiessereiTable", $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    public function getForm($data = array(), $loadData = true)
    {
        $options = array('control' => 'jform', 'load_data' => $loadData);
        $form = $this->loadForm('ojournals', 'ojournal', $options);

        if (empty($form)) {
            return (false);
        }
        return $form;
    }

    protected function loadFormData()
    {
        $app = JFactory::getApplication();
        $data = $app->getUserState('com_giesserei.edit.ojournal.data', array());

        if (empty($data)) {
            $data = $this->getItem();
        }

        return $data;
    }

    // Liest die Klassen aus für die Journaleinträge
    public function getObjectjournalClasses()
    {
        $db =& JFactory::getDBO();
        $query = "SELECT * FROM #__mgh_ojournalklasse ORDER BY id";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        return ($rows);
    }
}

?>

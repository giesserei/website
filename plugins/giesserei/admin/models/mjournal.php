<?php
/*
 * Created on 27.12.2010; Sub?
 * 
 */
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modeladmin');

class GiessereiModelMJournal extends JModelAdmin
{

    public function getTable($type = "MJournals", $prefix = "GiessereiTable", $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    public function getForm($data = array(), $loadData = true)
    {
        $options = array('control' => 'jform', 'load_data' => $loadData);
        $form = $this->loadForm('mjournals', 'mjournal', $options);

        if (empty($form)) {
            return (false);
        }
        return $form;
    }

    protected function loadFormData()
    {
        $app = JFactory::getApplication();
        $data = $app->getUserState('com_giesserei.edit.mjournal.data', array());

        if (empty($data)) {
            $data = $this->getItem();
        }

        return $data;
    }

    // Liest die Klassen aus für die Journaleinträge
    public function getMemberjournalClasses()
    {
        $db =& JFactory::getDBO();
        $query = "SELECT * FROM #__mgh_mjournalklasse ORDER BY id";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        return ($rows);
    }
}

?>

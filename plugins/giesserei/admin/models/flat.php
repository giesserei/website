<?php

defined('_JEXEC') or die('Restricted access');

class GiessereiModelFlat extends JModelAdmin
{

    public function getTable($type = "Flats", $prefix = "GiessereiTable", $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    public function getForm($data = array(), $loadData = true)
    {
        $options = array('control' => 'jform', 'load_data' => $loadData);
        $form = $this->loadForm('flats', 'flat', $options);

        if (empty($form)) {
            return (false);
        }
        return $form;
    }

    protected function loadFormData()
    {
        $app = JFactory::getApplication();
        $data = $app->getUserState('com_giesserei.edit.flat.data', array());

        if (empty($data)) {
            $data = $this->getItem();
        }

        return $data;
    }

    /**
     * Liest die Wohnungstypen aus für Edit-Form
     */
    public function getFlatTypes()
    {
        $db = JFactory::getDBO();
        $query = "SELECT * FROM #__mgh_objekttyp ORDER BY bezeichnung";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        return ($rows);
    }

    /**
     * Liest die Bewohnerschaft aus für Edit-Form
     */
    public function getBewohner()
    {
        $db =& JFactory::getDBO();
        $data = $this->loadFormData();

        $query = "SELECT * FROM #__mgh_mitglied as mgl,#__mgh_x_mitglied_mietobjekt as xmo"
                 ." WHERE mgl.userid=xmo.userid AND objektid=" . $data->id . " ORDER BY nachname";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        return ($rows);
    }

    // Liest die Kinder einer Wohnung aus für Edit-Form
    public function getKids()
    {
        $db = JFactory::getDBO();
        $data = $this->loadFormData();

        $query = "SELECT * FROM #__mgh_kind WHERE objektid=" . $data->id;
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        return ($rows);
    }

    // Liest das Journal einer Wohnung
    public function getJournal()
    {
        $data = $this->loadFormData();
        $db = JFactory::getDBO();

        $query = "SELECT *,oj.id as id FROM #__mgh_objektjournal as oj,#__mgh_ojournalklasse as jk"
                 ." WHERE oj.klasseid=jk.id AND objektid=" . $data->id . " ORDER BY datum";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        return ($rows);
    }
}

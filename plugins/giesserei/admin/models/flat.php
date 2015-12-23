<?php

defined('_JEXEC') or die('Restricted access');

JLoader::register('GiessereiHelper', JPATH_COMPONENT . '/helpers/giesserei.php');

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
     * Wohnungen können nicht gelöscht werden.
     *
     * @param object $record
     * @return boolean
     */
    protected function canDelete($record)
    {
        return false;
    }

    /**
     * Liest die Bewohnerschaft einer Wohnung aus zur Anzeige im Edit-Form
     */
    public function getBewohner()
    {
        $db = JFactory::getDBO();
        $data = $this->loadFormData();

        $query = "SELECT * FROM #__mgh_mitglied as mgl LEFT JOIN #__mgh_x_mitglied_mietobjekt as xmo"
                 ." ON mgl.userid = xmo.userid"
                 ." WHERE objektid=" . $data->id . " ORDER BY nachname";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        return ($rows);
    }

    /**
     * Liest die Kinder einer Wohnung aus zur Anzeige im Edit-Form
     */
    public function getKids()
    {
        $db = JFactory::getDBO();
        $data = $this->loadFormData();

        $query = "SELECT * FROM #__mgh_kind WHERE objektid=" . $data->id;
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        return ($rows);
    }

}

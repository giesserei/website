<?php
defined('_JEXEC') or die('Restricted access');

class GiessereiModelKid extends JModelAdmin
{

    public function getTable($type = "Kids", $prefix = "GiessereiTable", $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    public function getForm($data = array(), $loadData = true)
    {
        $options = array('control' => 'jform', 'load_data' => $loadData);
        $form = $this->loadForm('kids', 'kid', $options);

        if (empty($form)) {
            return (false);
        }

        $user = JFactory::getUser();
        $canEditFull = $user->authorise('edit.member', 'com_giesserei');

        // Nur für VKom-Daten berechtigt -> Felder nur zur Ansicht freischalten
        if (!$canEditFull) {
            $this->disableField($form, 'vorname');
            $this->disableField($form, 'nachname');
            $this->disableField($form, 'jahrgang');
            $this->disableField($form, 'jahrgang_frei');
            $this->disableField($form, 'handy');
            $this->disableField($form, 'handy_frei');
        }

        return $form;
    }

    protected function loadFormData()
    {
        $app = JFactory::getApplication();
        $data = $app->getUserState('com_giesserei.edit.kid.data', array());

        if (empty($data)) {
            $data = $this->getItem();
        }

        return $data;
    }

    // -------------------------------------------------------------------------
    // private section
    // -------------------------------------------------------------------------

    /**
     * Zeigt das übergebene Feld schreibgeschützt an und verhindert das Speichern von Werten für dieses Feld.
     * Das Attribut "required" wird auf false gesetzt, sonst kann nicht gespeichert werden.
     */
    private function disableField($form, $fieldName)
    {
        $form->setFieldAttribute($fieldName, 'disabled', 'true');
        $form->setFieldAttribute($fieldName, 'required', 'false');
        $form->setFieldAttribute($fieldName, 'filter', 'unset');
    }

}

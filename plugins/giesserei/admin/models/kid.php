<?php
defined('_JEXEC') or die('Restricted access');

JLoader::register('GiessereiHelper', JPATH_COMPONENT . '/helpers/giesserei.php');

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

        // VKom hat nicht alle Rechte => nur Anzeige ist möglich
        if (!$canEditFull) {
            GiessereiHelper::disableField($form, 'vorname');
            GiessereiHelper::disableField($form, 'nachname');
            GiessereiHelper::disableField($form, 'jahrgang');
            GiessereiHelper::disableField($form, 'jahrgang_frei');
            GiessereiHelper::disableField($form, 'handy');
            GiessereiHelper::disableField($form, 'handy_frei');
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

    /**
     * Werte für ungesetzte Checkboxen vor dem Speichern setzen.
     *
     * @inheritdoc
     */
    protected function prepareTable($table)
    {
        $app = JFactory::getApplication();
        $input = $app->input;
        $data = $input->get('jform', '', 'array');

        if (!isset($data['jahrgang_frei'])) {
            $table->jahrgang_frei = 0;
        }
        if (!isset($data['handy_frei'])) {
            $table->handy_frei = 0;
        }
    }
}

<?php
defined('_JEXEC') or die('Restricted access');

JLoader::register('GiessereiFrontendHelper', JPATH_COMPONENT . '/helpers/giesserei_frontend.php');
JLoader::register('GiessereiConst', JPATH_COMPONENT . '/helpers/giesserei_const.php');

jimport('joomla.log.log');

/**
 * Model zum Ändern des Passworts eines Mitglieds.
 *
 * @author Steffen Förster
 */
class GiessereiModelUpdpassword extends JModelAdmin
{

    public function getItem($pk = null)
    {
        $user = JFactory::getUser();
        $item = parent::getItem($user->id);
        return $item;
    }

    public function getTable($type = 'Profil', $prefix = 'GiessereiTable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    public function getForm($data = array(), $loadData = true)
    {
        GiessereiFrontendHelper::methodBegin('GiessereiModelUpdpassword', 'getForm', 'loadData:' . $loadData);

        $form = $this->loadForm('com_giesserei.updpassword', 'updpassword', array(
            'control' => 'jform',
            'load_data' => $loadData
        ));

        if (empty($form)) {
            return false;
        }

        return $form;
    }

    /**
     * Prüft, ob die Eingaben korrekt sind.
     *
     * Validierungsmeldungen werden im Model gespeichert.
     *
     * @return mixed  Array mit gefilterten Daten, wenn alle Daten korrekt sind; sonst false
     */
    public function validate($form, $data)
    {
        $validateResult = parent::validate($form, $data);
        if ($validateResult === false) {
            return false;
        }

        $valid = $this->validatePassword($validateResult['password'], $validateResult['password2']);
        if (!$valid) {
            return false;
        }

        return $validateResult;
    }

    /**
     * Eigene Implementierung der save-Methode.
     *
     * @return true, wenn das Speichern erfolgreich war, sonst false
     */
    public function save($data)
    {
        GiessereiFrontendHelper::methodBegin('GiessereiModelUpdprofil', 'save');

        $user = JFactory::getUser();
        $table = new JUser($user->id);

        try {
            // Passwortfelder an die Tabelle JUser binden
            if (!$table->bind($data)) {
                return false;
            }

            // User speichern -> nur Update
            if (!$table->save(true)) {
                JLog::add($table->getError(), JLog::ERROR);
                $this->setError('Speichern fehlgeschlagen!');
                return false;
            }
        } catch (Exception $e) {
            JLog::add($e->getMessage(), JLog::ERROR);
            $this->setError('Speichern fehlgeschlagen!');
            return false;
        }

        return true;
    }

    // -------------------------------------------------------------------------
    // protected section
    // -------------------------------------------------------------------------

    protected function loadFormData()
    {
        GiessereiFrontendHelper::methodBegin('GiessereiModelUpdpassword', 'loadFormData');

        return array();
    }

    // -------------------------------------------------------------------------
    // private section
    // -------------------------------------------------------------------------

    /**
     * Liefert true, wenn die beiden Passwörter gleich sind und mindestens 8 Zeichen lang sind.
     * Die Fehlermeldung wird im Model gespeichert.
     */
    private function validatePassword($password, $password2)
    {
        if (strlen($password) < 8) {
            $this->setError('Das Passwort ist zu kurz');
            return false;
        }
        if ($password != $password2) {
            $this->setError('Die Passwörter sind nicht gleich');
            return false;
        }
        return true;
    }

}
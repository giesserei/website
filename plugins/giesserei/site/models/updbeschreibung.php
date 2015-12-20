<?php
defined('_JEXEC') or die('Restricted access');

JLoader::register('GiessereiFrontendHelper', JPATH_COMPONENT . '/helpers/giesserei_frontend.php');
JLoader::register('GiessereiConst', JPATH_COMPONENT . '/helpers/giesserei_const.php');

jimport('joomla.log.log');

/**
 * Model zum Editieren der Beschreibung eines Mitglieds.
 *
 * @author Steffen Förster
 */
class GiessereiModelUpdbeschreibung extends JModelAdmin
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
        GiessereiFrontendHelper::methodBegin('GiessereiModelUpdbeschreibung', 'getForm', 'loadData:' . $loadData);

        $form = $this->loadForm('com_giesserei.updbeschreibung', 'updbeschreibung', array(
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

        // Beschreibung extra filtern, da Form-Filterung des Editors mit Joomla2.5 nicht funktioniert
        $validateResult['zur_person'] = JComponentHelper::filterText($validateResult['zur_person']);

        return $validateResult;
    }

    /**
     * Eigene Implementierung der save-Methode.
     *
     * @return true, wenn das Speichern erfolgreich war, sonst false
     */
    public function save($data)
    {
        GiessereiFrontendHelper::methodBegin('GiessereiModelUpdbeschreibung', 'save');

        $user = JFactory::getUser();
        $table = $this->getTable();

        try {
            // Daten in die Tabellen-Instanz laden
            $table->load($user->id);

            // Properties mit neuen Daten überschreiben
            // ID und User-ID nicht überschreiben -> sicherstellen, dass diese nicht verändert werden
            if (!$table->bind($data, "id, userid")) {
                $this->setError($table->getError());
                return false;
            }

            // Tabelle kann vor dem Speichern letzte Datenprüfung vornehmen
            if (!$table->check()) {
                $this->setError($table->getError());
                return false;
            }

            // Jetzt Daten speichern -> Nur Mitglieder-Tabelle
            if (!$table->store(true, false)) {
                $this->setError($table->getError());
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
        GiessereiFrontendHelper::methodBegin('GiessereiModelUpdbeschreibung', 'loadFormData');

        $data = JFactory::getApplication()->getUserState(GiessereiConst::SESSION_KEY_PROFIL_DATA, array());

        if (empty($data)) {
            $data = $this->getItem();
        }

        return $data;
    }
}
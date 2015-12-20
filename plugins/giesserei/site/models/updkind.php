<?php
defined('_JEXEC') or die('Restricted access');

JLoader::register('GiessereiFrontendHelper', JPATH_COMPONENT . '/helpers/giesserei_frontend.php');
JLoader::register('GiessereiConst', JPATH_COMPONENT . '/helpers/giesserei_const.php');

jimport('joomla.log.log');

/**
 * Model zum Editieren eines Kindes eines Mitglieds.
 *
 * @author Steffen Förster
 */
class GiessereiModelUpdkind extends JModelAdmin
{

    /**
     * Prüft, ob der Benutzer in der gleichen Wohnung, wie das Kind wohnt, welches bearbeitet werden soll.
     * So wird verhindert, dass durch Übergabe einer beliebigen ID die Daten eines anderen Kindes bearbeitet
     * werden können.
     */
    public function isOwner($kindId = null)
    {
        $app = JFactory::getApplication();
        $user = JFactory::getUser();
        $db = JFactory::getDBO();

        if (empty($kindId)) {
            $kindId = $app->getUserState(GiessereiConst::SESSION_KEY_PROFIL_SUB_ID);
        }

        $query = sprintf(
            'SELECT count(*) anzahl
         FROM #__mgh_x_mitglied_mietobjekt mo JOIN #__mgh_kind k ON mo.objektid = k.objektid
         WHERE mo.userid = %s AND k.id = %s',
            $user->id,
            mysql_real_escape_string($kindId));

        $db->setQuery($query);
        $row = $db->loadObject();
        return !empty($row) && $row->anzahl == 1;
    }

    public function getItem($pk = null)
    {
        $app = JFactory::getApplication();
        $kindId = $app->getUserState(GiessereiConst::SESSION_KEY_PROFIL_SUB_ID);
        $item = parent::getItem($kindId);
        return $item;
    }

    public function getTable($type = 'Kids', $prefix = 'GiessereiTable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    public function getForm($data = array(), $loadData = true)
    {
        GiessereiFrontendHelper::methodBegin('GiessereiModelUpdkind', 'getForm', 'loadData:' . $loadData);

        $form = $this->loadForm('com_giesserei.updkind', 'updkind', array(
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

        return $validateResult;
    }

    /**
     * Eigene Implementierung der save-Methode.
     *
     * @return true, wenn das Speichern erfolgreich war, sonst false
     */
    public function save($data)
    {
        GiessereiFrontendHelper::methodBegin('GiessereiModelUpdkind', 'save');

        $app = JFactory::getApplication();
        $table = $this->getTable();

        try {
            // Daten in die Tabellen-Instanz laden
            $kindId = $app->getUserState(GiessereiConst::SESSION_KEY_PROFIL_SUB_ID);
            $table->load($kindId);

            // Properties mit neuen Daten überschreiben
            // ID und objektid nicht überschreiben -> sicherstellen, dass diese nicht verändert werden
            if (!$table->bind($data, "id, objektid")) {
                $this->setError($table->getError());
                return false;
            }

            // Tabelle kann vor dem Speichern letzte Datenprüfung vornehmen
            if (!$table->check()) {
                $this->setError($table->getError());
                return false;
            }

            // Jetzt Daten speichern
            if (!$table->store()) {
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
        GiessereiFrontendHelper::methodBegin('GiessereiModelUpdkind', 'loadFormData');

        $data = JFactory::getApplication()->getUserState(GiessereiConst::SESSION_KEY_PROFIL_DATA, array());

        if (empty($data)) {
            $data = $this->getItem();
        }

        return $data;
    }
}
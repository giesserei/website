<?php
defined('_JEXEC') or die('Restricted access');

JLoader::register('MitgliedTypEnum', JPATH_COMPONENT_ADMINISTRATOR . '/models/enums/mitglied_typ.php');

/**
 * Tabelle zum Speichern der Vereinsmitglieder.
 */
class GiessereiTableMembers extends JTable
{
    // Tabellenfelder
    public $id;
    public $userid = null;
    public $vorname = null;
    public $nachname = null;
    public $adresse = null;
    public $plz = null;
    public $ort = null;
    public $telefon = null;
    public $telefon_frei;
    public $handy = null;
    public $handy_frei;
    public $jahrgang;
    public $zur_person;
    public $funktion;
    public $eintritt;
    public $austritt; // entspricht bei Aktivmitgliedern (Bewohnern) dem Auszugsdatum
    public $einzug;
    public $typ;
    public $update_userid;
    public $update_timestamp;
    public $dispension_grad;
    public $kommentar;
    public $zb_freistellung;

    // Zusätzliche Properties, die für die Bearbeitung eines Datensatzes benötigt werden
    // oder die einfach nur in der Liste angezeigt werden
    protected $email;
    protected $wohnung;
    protected $kinder;
    protected $avatar;
    protected $birthdate;
    protected $websitename;
    protected $websiteurl;
    protected $gender;
    protected $status;
    protected $typ_name;

    protected $is_update_user_name;
    protected $is_update_permission;

    public function __construct(&$db)
    {
        parent::__construct('#__mgh_mitglied', 'id', $db);
    }

    /**
     * Vor dem Speichern eines Datensatzes werden die Daten aus den zusätzlichen
     * Properties in andere Tabellen gespeichert.
     */
    public function store($updateNulls = false)
    {
        $user = JFactory::getUser();
        $this->update_userid = $user->id;
        $this->update_timestamp = date('Y-m-d H:i:s');

        if (!$this->updateMietobjekt()) {
            return false;
        }
        if (!$this->writeInHistory()) {
            return false;
        }
        if (!$this->updateUserName()) {
            return false;
        }
        if (!$this->updateUserPermissions()) {
            return false;
        }

        return parent::store($updateNulls);
    }

    public function setUpdateUserName($isUpdateUserName)
    {
        $this->is_update_user_name = $isUpdateUserName;
    }

    public function setUpdatePermission($isUpdatePermission)
    {
        $this->is_update_permission = $isUpdatePermission;
    }

    // -------------------------------------------------------------------------
    // private section
    // -------------------------------------------------------------------------

    private function updateMietobjekt()
    {
        $db = JFactory::getDBO();

        // Wohnungen in Kreuztabelle einspeisen
        // Aufsplitten in einzelne Einträge, falls durch Komma getrennt
        $wohnungen = explode(",", $this->wohnung);

        if (count($wohnungen) > 0) {
            // Zuerst alle Einträge des Mitgliedes löschen
            $query = "DELETE FROM #__mgh_x_mitglied_mietobjekt WHERE userid=" . $this->userid;
            $db->setQuery($query);
            if (!$db->query()) {
                $this->setError($db->getErrorMsg());
                return false;
            }

            // dann alle neuen Mietobjekte schreiben
            foreach ($wohnungen as $whg) {
                if (strval($whg) > 2000 and strval($whg) < 3000) {
                    $query = "INSERT INTO #__mgh_x_mitglied_mietobjekt (userid,objektid) VALUES ('" . $this->userid . "','" . $whg . "')";
                    $db->setQuery($query);
                    if (!$db->query()) {
                        $this->setError($db->getErrorMsg());
                        return false;
                    }
                }
            }
        }
        return true;
    }

    private function writeInHistory()
    {
        if (!empty($this->id)) {
            $history = JTable::getInstance('MembersHistory', 'GiessereiTable', array());
            $history->setIdToSave($this->id);
            if (!$history->store()) {
                $this->setError($history->getError());
                return false;
            }
        }
        return true;
    }

    /**
     * Überschreibt den Namen in der Users-Tabelle mit dem Vor- und Nachnamen.
     */
    private function updateUserName()
    {
        if ($this->is_update_user_name == 1) {
            $db = JFactory::getDBO();
            $query = "UPDATE #__users SET name = '" . $this->vorname . " " . $this->nachname . "' WHERE id = " . $this->userid;
            $db->setQuery($query);
            if (!$db->query()) {
                $this->setError($db->getErrorMsg());
                return false;
            }
        }
        return true;
    }

    /**
     * Bei Passivmitgliedern wird die Berechtigung automatisch gesetzt.
     */
    private function updateUserPermissions()
    {
        if ($this->is_update_permission == 1) {
            if ($this->typ == MitgliedTypEnum::PASSIVMITGLIED || $this->typ == MitgliedTypEnum::PASSIVMITGLIED_DEAKTIVIERT) {
                $groupId = $this->getGroupIdByTyp($this->typ);
                if ($groupId === false) {
                    return false;
                }

                $groupIdEmail = $this->getGroupIdByName("keine Email-Adresse");
                if ($groupIdEmail === false) {
                    return false;
                }

                $db = JFactory::getDBO();

                // Zunächst alle Rechte des Users löschen -> Gruppe "keine Email-Adresse" bleibt bestehen
                $query = "DELETE FROM #__user_usergroup_map WHERE user_id = " . $this->userid . " AND group_id != " . $groupIdEmail;
                $db->setQuery($query);
                if (!$db->query()) {
                    $this->setError($db->getErrorMsg());
                    return false;
                }

                // Nun das Passivmitglied-Recht setzen
                $query = "INSERT INTO #__user_usergroup_map (user_id, group_id) VALUES (" . $this->userid . "," . $groupId . ")";
                $db->setQuery($query);
                if (!$db->query()) {
                    $this->setError($db->getErrorMsg());
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Ermittelt die Benutzergruppe für den übergebenen Mitgliedstyp.
     *
     * @param string $typ
     * @return mixed false, wenn die Gruppe nicht gefunden wurde
     */
    private function getGroupIdByTyp($typ)
    {
        $name = "";
        if ($typ == MitgliedTypEnum::PASSIVMITGLIED) {
            $name = "Passivmitglied";
        } else if ($typ == MitgliedTypEnum::PASSIVMITGLIED_DEAKTIVIERT) {
            $name = "Passivmitglied deaktiviert";
        } else {
            $this->setError("Typ ist nicht unterstützt: " + $typ);
            return false;
        }

        return $this->getGroupIdByName($name);
    }

    /**
     * Ermittelt die Benutzergruppe, welche den übergebenen Namen hat.
     *
     * @param string $name Name der Benutzergruppe
     * @return mixed false, wenn die Gruppe nicht gefunden wurde
     */
    private function getGroupIdByName($name)
    {
        $db = JFactory::getDBO();
        $query = "SELECT id FROM #__usergroups WHERE title = '" . $name . "'";
        $db->setQuery($query);
        $row = $db->loadObject();
        if (empty($row)) {
            $this->setError("Benutzergruppe " . $name . " nicht gefunden!");
            return false;
        }
        return $row->id;
    }
}

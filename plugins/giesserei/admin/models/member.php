<?php
defined('_JEXEC') or die('Restricted access');

JLoader::register('GiessereiHelper', JPATH_COMPONENT . '/helpers/giesserei.php');

class GiessereiModelMember extends JModelAdmin
{

    /**
     * Liefert ein Objekt der Klasse GiessereiTableMembers (tables/members.php).
     *
     * @inheritdoc
     */
    public function getTable($type = "Members", $prefix = "GiessereiTable", $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    public function getForm($data = array(), $loadData = true)
    {
        $options = array(
            'control' => 'jform',
            'load_data' => $loadData
        );
        $form = $this->loadForm('members', 'member', $options);

        if (empty($form)) {
            return false;
        }

        $user = JFactory::getUser();
        $canEditFull = $user->authorise('edit.member', 'com_giesserei');

        // Wenn nicht volle Berechtigungen (z.B. VKom) -> Felder nur zur Ansicht freischalten
        if (!$canEditFull) {
            GiessereiHelper::disableField($form, 'vorname');
            GiessereiHelper::disableField($form, 'nachname');
            GiessereiHelper::disableField($form, 'adresse');
            GiessereiHelper::disableField($form, 'plz');
            GiessereiHelper::disableField($form, 'ort');
            GiessereiHelper::disableField($form, 'jahrgang');
            GiessereiHelper::disableField($form, 'userid');
            GiessereiHelper::disableField($form, 'zur_person');
            GiessereiHelper::disableField($form, 'is_update_user_name');
            GiessereiHelper::disableField($form, 'is_update_permission');
            GiessereiHelper::disableField($form, 'telefon');
            GiessereiHelper::disableField($form, 'telefon_frei');
            GiessereiHelper::disableField($form, 'handy');
            GiessereiHelper::disableField($form, 'handy_frei');
            GiessereiHelper::disableField($form, 'eintritt');
            GiessereiHelper::disableField($form, 'austritt');
            GiessereiHelper::disableField($form, 'einzug');
            GiessereiHelper::disableField($form, 'typ');
            GiessereiHelper::disableField($form, 'kommentar');
            GiessereiHelper::disableField($form, 'dispension_grad');
            GiessereiHelper::disableField($form, 'zb_freistellung');
            GiessereiHelper::disableField($form, 'zb_ausbildung_bis');
        }

        $ausbildung = 'nein';
        if ($form->getValue('zb_ausbildung_bis')) {
            $dateAusbildungEnde = new DateTime($form->getValue('zb_ausbildung_bis'));
            $dateYearStart = new DateTime(intval(date('Y')) . '-01-01');

            if ($dateAusbildungEnde > $dateYearStart) {
                $ausbildung = 'ja';
            }
        }
        $form->setValue('zb_ausbildung', null, $ausbildung);

        return $form;
    }

    /**
     * Liefert einen einzelnen Datensatz eines Mitglieds.
     * Der Datensatz wird um Attribute aus anderen Tabellen ergänzt.
     *
     * @inheritdoc
     */
    public function getItem($pk = null)
    {
        $db = JFactory::getDBO();
        $item = parent::getItem();

        if (empty($item->userid)) {
            return $item;
        }

        // E-Mailadresse zuweisen
        $query = "SELECT * FROM #__users WHERE id = " . $item->userid;
        $db->setQuery($query);
        $rows = $db->loadObjectList();

        if ($db->getAffectedRows() > 0) {
            $item->email = $rows [0]->email;
        }

        // Gibt es für das Mitglied $userid einen oder mehrere Mietverträge?
        $query = "SELECT * FROM #__mgh_x_mitglied_mietobjekt WHERE userid='" . $item->userid . "'";
        $db->setQuery($query);
        $rows = $db->loadObjectList();

        $item->wohnung = "";
        if ($db->getAffectedRows() > 0) {
            foreach ($rows as $whg) {
                $item->wohnung .= $whg->objektid;
                if ($whg != end($rows)) {
                    $item->wohnung .= ", ";
                }
            }
        }

        $item->is_update_user_name = 0;
        $item->is_update_permission = 0;

        return $item;
    }

    protected function loadFormData()
    {
        $app = JFactory::getApplication();
        $data = $app->getUserState('com_giesserei.edit.Member.data', array());

        if (empty($data)) {
            $data = $this->getItem();
        }

        return $data;
    }

    /**
     * Ungesetzte Checkboxen verarbeiten.
     *
     * @param GiessereiTableMembers $table
     */
    protected function prepareTable($table)
    {
        $app = JFactory::getApplication();
        $input = $app->input;
        $data = $input->get('jform', '', 'array');

        if (!isset($data['is_update_user_name'])) {
            $table->setUpdateUserName(0);
        }
        if (!isset($data['is_update_permission'])) {
            $table->setUpdateUserName(0);
        }
        if (!isset($data['telefon_frei'])) {
            $table->telefon_frei = 0;
        }
        if (!isset($data['handy_frei'])) {
            $table->handy_frei = 0;
        }
        // Kommentar kürzen
        $table->kommentar = GiessereiHelper::cropText($table->kommentar, 500);
    }

    /**
     * Liefert alle Mitbewohner der Wohnungen, die vom aktuell selektierten Bewohner gemietet sind.
     */
    public function getMitbewohner()
    {
        $db = JFactory::getDBO();
        $data = $this->loadFormData();

        $query =
            "SELECT a.* FROM #__mgh_mitglied as a
             WHERE a.userid IN (
                 SELECT b.userid FROM #__mgh_x_mitglied_mietobjekt as b
                 WHERE b.objektid IN (
                     SELECT c.objektid FROM #__mgh_x_mitglied_mietobjekt as c WHERE c.userid = " . $data->userid . "
                 )
             )
             AND a.userid != " . $data->userid . "
             ORDER BY a.nachname";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        return ($rows);
    }

    /**
     * Liefert alle Kinder der Wohnungen, die vom aktuell selektierten Bewohner gemietet sind.
     */
    public function getKinder()
    {
        $db = JFactory::getDBO();
        $data = $this->loadFormData();

        $query =
            "SELECT a.* FROM #__mgh_kind as a
             WHERE a.objektid IN (
                 SELECT b.objektid FROM #__mgh_x_mitglied_mietobjekt as b WHERE b.userid = " . $data->userid . "
             )
             ORDER BY a.nachname";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        return ($rows);
    }
}

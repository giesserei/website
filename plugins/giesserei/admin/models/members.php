<?php
defined('_JEXEC') or die('Restricted access');

class GiessereiModelMembers extends JModelList
{

    public function __construct($config = array())
    {
        // Spalten definieren, nach denen sortiert werden kann
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'mgl.vorname',
                'mgl.nachname',
                'mgl.jahrgang',
                'typ_name',
                'mgl.userid'
            );
        }
        parent::__construct($config);
    }

    /**
     * Request-Parameter in den Model-State schreiben.
     */
    protected function populateState($ordering = null, $direction = null)
    {
        // Such-Filter setzen
        $search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        // Typ-Filter setzen
        $typ = $this->getUserStateFromRequest($this->context . '.filter.typ', 'filter_typ');
        $this->setState('filter.typ', $typ);

        // Status-Filter setzen
        $status = $this->getUserStateFromRequest($this->context . '.filter.status', 'filter_status');
        $this->setState('filter.status', $status);

        // Quality-Filter setzen
        $quality = $this->getUserStateFromRequest($this->context . '.filter.quality', 'filter_quality');
        $this->setState('filter.quality', $quality);

        // Component parameters.
        $params = JComponentHelper::getParams('com_giesserei');
        $this->setState('params', $params);

        // Restliche State-Parameter setzen (z.B. Page-Limit) und die Default-Sortierung
        parent::populateState('mgl.nachname', 'asc');
    }

    /**
     * Method to get a store id based on model configuration state.
     *
     * This is necessary because the model is used by the component and
     * different modules that might need different sets of data or different
     * ordering requirements.
     *
     * @param   string $id A prefix for the store id.
     *
     * @return  string  A store id.
     */
    protected function getStoreId($id = '')
    {
        // Compile the store id.
        $id .= ':' . $this->getState('filter.search');
        $id .= ':' . $this->getState('filter.typ');
        $id .= ':' . $this->getState('filter.status');
        $id .= ':' . $this->getState('filter.quality');

        return parent::getStoreId($id);
    }

    /**
     * Liefert die SQL-Query zum Laden der Mitglieder. Es werden die Filter berücksichtigt.
     */
    protected function getListQuery()
    {
        $db = $this->getDBO();
        $query = $db->getQuery(true);

        $query->select('mgl.*');

        // Mitgliederstatus 0 -> ausgetreten
        $query->select('IF ((mgl.austritt >= NOW() OR mgl.austritt is null), 1, 0) AS status');

        // Wohnung
        $query->select('(SELECT GROUP_CONCAT(DISTINCT o.objektid ORDER BY o.objektid DESC SEPARATOR \',\')
                     FROM #__mgh_mitglied m, #__mgh_x_mitglied_mietobjekt o
                     WHERE o.userid = mgl.userid) AS wohnung');

        // Typ der Mitgliedschaft als String
        $query->select('CASE
        WHEN (mgl.typ = 1) THEN \'Bewohner\'
        WHEN (mgl.typ = 2) THEN \'Gewerbe\'
        WHEN (mgl.typ = 3) THEN \'Passivmitglied\'
        WHEN (mgl.typ = 4) THEN \'Passivmitglied deaktiviert\'
        WHEN (mgl.typ = 5) THEN \'Siedlungsassistenz\'
        WHEN (mgl.typ = 6) THEN \'Hausverein\'
        WHEN (mgl.typ = 7) THEN \'Stundenfonds\'
        WHEN (mgl.typ = 8) THEN \'Chupferhammer\'
        WHEN (mgl.typ = 11) THEN \'Jugendmitglied\'
        ELSE \'unbekannt\'
        END AS typ_name');

        $query->from('#__mgh_mitglied as mgl');

        // Join der User-Tabelle
        $query->select('usr.email as email');
        $query->join('LEFT', '#__users AS usr ON usr.id = mgl.userid');

        // Join der Forum-Tabelle
        $query->select('kun.avatar as avatar');
        $query->join('LEFT', '#__kunena_users AS kun ON mgl.userid = kun.userid');


        // Filter by search in vorname, nachname, or id
        if ($search = trim($this->getState('filter.search'))) {
            if (stripos($search, 'id:') === 0) {
                $query->where('mgl.userid = ' . (int)substr($search, 3));
            } else {
                $search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%'));
                $query->where('(mgl.nachname LIKE ' . $search . ' OR mgl.vorname LIKE ' . $search . ')');
            }
        }

        $this->addFilterTyp($query);
        $this->addFilterStatus($query);
        $this->addFilterQuality($query);

        // Sortierung
        $query->order($db->escape($this->getState('list.ordering', 'mgl.nachname')) . ' ' .
            $db->escape($this->getState('list.direction', 'asc')));

        return $query;
    }

    // -------------------------------------------------------------------------
    // private section
    // -------------------------------------------------------------------------

    /**
     * Ergänzt die Query um den Filter, mit dem nach dem Typ gefiltert werden kann.
     *
     * @param JDatabaseQuery $query
     */
    private function addFilterTyp(&$query)
    {
        $typ = $this->getState('filter.typ');
        if (!empty($typ)) {
            switch (strval($typ)) {
                case 2 : // Bewohner
                    $query->where('(mgl.typ = 1)');
                    break;
                case 3 : // Gewerbe
                    $query->where('(mgl.typ = 2)');
                    break;
                case 4 : // Passivmitglied
                    $query->where('(mgl.typ = 3)');
                    break;
                case 5 : // Passivmitglied deaktiviert
                    $query->where('(mgl.typ = 4)');
                    break;
                default : // kein Filter
            }
        }
    }

    /**
     * Ergänzt die Query um den Filter, mit dem nach dem Status gefiltert werden kann.
     *
     * @param JDatabaseQuery $query
     */
    private function addFilterStatus(&$query)
    {
        $status = $this->getState('filter.status');
        if (!empty($status)) {
            switch (strval($status)) {
                case 2 : // nur aktive Mitglieder
                    $query->where('(mgl.austritt >= NOW() OR mgl.austritt is null)');
                    break;
                case 3 : // ausgetreten
                    $query->where('(mgl.austritt < NOW() AND mgl.austritt is not null)');
                    break;
                default : // kein Filter
            }
        }
    }

    /**
     * Ergänzt die Query um den Filter, mit dem Mitglieder gesucht werden können, deren Datenqualität nicht gut ist.
     *
     * @param JDatabaseQuery $query
     */
    private function addFilterQuality(&$query)
    {
        $quality = $this->getState('filter.quality');
        if (!empty($quality)) {
            switch (strval($quality)) {
                case 2 : // Bewohner/Gewerbe ohne Einzugsdatum
                    $query->where('(mgl.typ IN (1,2) AND mgl.einzug is null)');
                    break;
                case 3 : // keine E-Mail Adresse
                    $query->where('(usr.email LIKE \'%keine.email%\' OR usr.email LIKE \'%kein.email%\')');
                    break;
                case 4 : // nicht ausgezogener Bewohner/Gewerbe mit falscher Adresse
                    $query->where("(mgl.typ IN (1,2) AND (mgl.austritt >= NOW() OR mgl.austritt is null) AND (mgl.adresse NOT LIKE '%Ida-Sträuli%' OR mgl.plz != '8404' OR mgl.ort != 'Winterthur'))");
                    break;
                case 5 : // Bewohner/Gewerbe ohne Wohnung
                    $query->where("(mgl.typ IN (1,2) AND NOT EXISTS (SELECT o1.objektid FROM #__mgh_x_mitglied_mietobjekt o1 WHERE o1.userid = mgl.userid))");
                    break;
                case 6 : // Passivmitglied ausgetreten -> kann gelöscht werden
                    $query->where("(mgl.typ IN (3,4) AND mgl.austritt < NOW() AND mgl.austritt is not null)");
                    break;
                default : // kein Filter
            }
        }
    }

}

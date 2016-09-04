<?php

defined('_JEXEC') or die('Restricted access');

class GiessereiModelFlats extends JModelList
{

    public function __construct($config = array())
    {
        // Spalten definieren, nach denen sortiert werden kann
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'mo.id',
                'wohnung_typ',
                'mo.flaeche'
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

        // Component parameters.
        $params = JComponentHelper::getParams('com_giesserei');
        $this->setState('params', $params);

        // Restliche State-Parameter setzen (z.B. Page-Limit) und die Default-Sortierung
        parent::populateState('mo.id', 'asc');
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

        return parent::getStoreId($id);
    }

    protected function getListQuery()
    {
        $db = $this->getDBO();
        $query = $db->getQuery(true);

        $query->select('mo.*');

        $query->from('#__mgh_mietobjekt as mo');

        // Join mit Tabelle Objekttyp
        $query->select('CONCAT(ot.bezeichnung, \': \', ot.zimmerbezeichnung) as wohnung_typ');
        $query->join('LEFT', '#__mgh_objekttyp as ot ON mo.typid = ot.id');

        // Filter by search in vorname, nachname, or id
        if ($search = trim($this->getState('filter.search'))) {
            if (stripos($search, 'id:') === 0) {
                $query->where('mo.id = ' . (int)substr($search, 3));
            } else {
                $search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%'));
                $query->where('(CONCAT(ot.bezeichnung, \': \', ot.zimmerbezeichnung) LIKE ' . $search . ')');
            }
        }

        // Sortierung
        $query->order($db->escape($this->getState('list.ordering', 'mo.id')) . ' ' .
            $db->escape($this->getState('list.direction', 'asc')));

        return $query;
    }

}

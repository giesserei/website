<?php
defined('_JEXEC') or die('Restricted access');

JLoader::register('GiessereiHelper', JPATH_COMPONENT . '/helpers/giesserei.php');

class GiessereiViewFlats extends JViewLegacy
{
    protected $items;

    protected $pagination;

    protected $state;

    protected $sidebar;

    public $filterForm;

    public $activeFilters;

    public $ordering;

    public function display($tpl = null)
    {
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');
        $this->state = $this->get('State');
        $this->filterForm = $this->get('FilterForm');
        $this->activeFilters = $this->get('ActiveFilters');

        GiessereiHelper::addSubmenu('flats');

        $this->ordering = array();

        $this->addToolbar();
        $this->sidebar = JHtmlSidebar::render();

        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     *
     * @return  void
     */
    protected function addToolbar()
    {
        JToolbarHelper::title('Wohnungen');

        $user = JFactory::getUser();

        // Löschen und Neuanlegen ist nur per SQL möglich => sollte nur bei Umbauten notwendig werden
        JToolBarHelper::editList('flat.edit', 'JTOOLBAR_EDIT');

        if ($user->authorise('core.manage', 'com_giesserei')) {
            JToolBarHelper::preferences('com_giesserei');
        }
    }

    /**
     * Returns an array of fields the table can be sorted by
     *
     * @return  array  Array containing the field name to sort by as the key and display text as value
     */
    protected function getSortFields()
    {
        return array(
            'mo.id' => 'ID',
            'wohnung_typ' => 'Typ',
            'mo.flaeche' => 'Fläche'
        );
    }
}

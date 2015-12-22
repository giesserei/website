<?php
defined('_JEXEC') or die('Restricted access');

JLoader::register('GiessereiHelper', JPATH_COMPONENT . '/helpers/giesserei.php');

class GiessereiViewKids extends JViewLegacy
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

        GiessereiHelper::addSubmenu('kids');

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
        JToolbarHelper::title('Kinder von Bewohnern');

        $user = JFactory::getUser();

        // VKomm hat nur eingeschränkte Rechte
        $canEditFull = $user->authorise('edit.kid', 'com_giesserei');

        if ($canEditFull) {
            JToolBarHelper::addNew('kid.add', 'JTOOLBAR_NEW');
        }

        JToolBarHelper::editList('kid.edit', 'JTOOLBAR_EDIT');

        if ($canEditFull) {
            JToolBarHelper::deleteList('', 'kid.delete', 'JTOOLBAR_DELETE');
        }

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
            'a.id' => 'ID',
            'a.vorname' => 'Vorname',
            'a.nachname' => 'Nachname',
            'a.jahrgang' => 'Jahrgang'
        );
    }
}

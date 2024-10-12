<?php
defined('_JEXEC') or die;

JLoader::register('GiessereiHelper', JPATH_COMPONENT . '/helpers/giesserei.php');

class GiessereiViewMembers extends JViewLegacy
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

        GiessereiHelper::addSubmenu('members');

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
        JToolbarHelper::title('Mitglieder');

        $user = JFactory::getUser();

        // VKomm soll nur die Wohnungszuweisung bearbeiten dürfen => hat nicht das Recht 'edit.member'
        $canEditFull = $user->authorise('edit.member', 'com_giesserei');

        if ($canEditFull) {
            JToolBarHelper::addNew('member.add', 'JTOOLBAR_NEW');
        }

        JToolBarHelper::editList('member.edit', 'JTOOLBAR_EDIT');

        if ($canEditFull) {
            JToolBarHelper::deleteList('', 'members.delete', 'JTOOLBAR_DELETE');
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
            'mgl.userid' => 'ID',
            'mgl.vorname' => 'Vorname',
            'mgl.nachname' => 'Nachname',
            'mgl.jahrgang' => 'Jahrgang',
            'typ_name' => 'Typ'
        );
    }
}

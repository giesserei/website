<?php
defined('_JEXEC') or die('Restricted access');

class GiessereiViewFlats extends JViewLegacy
{
    protected $items;
    protected $pagination;
    protected $state;

    public function display($tpl = null)
    {
        JToolBarHelper::title('Wohnungslisten-Verwaltung', 'user.png');
        JToolBarHelper::editList('flat.edit', 'JTOOLBAR_EDIT');

        $this->items = $this->get('Items');

        $this->state = $this->get('State');
        $this->pagination = $this->get('Pagination');

        parent::display($tpl);
    }
}

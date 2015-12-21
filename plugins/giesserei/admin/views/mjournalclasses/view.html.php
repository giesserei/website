<?php
/*
 * Oktober 2013, JAL
 *
 */
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class GiessereiViewMJournalClasses extends JViewLegacy
{
    protected $items;
    protected $pagination;
    protected $state;

    public function display($tpl = null)
    {
        JToolBarHelper::title('Mitgliederlisten-Verwaltung: Journal-Klassen', 'user.png');
        JToolBarHelper::addNew('mjournalclasse.add', 'JTOOLBAR_NEW');
        JToolBarHelper::editList('mjournalclasse.edit', 'JTOOLBAR_EDIT');
        JToolBarHelper::deleteList('', 'mjournalclasses.delete', 'JTOOLBAR_DELETE');

        $this->items = $this->get('Items');

        $this->state = $this->get('State');
        $this->pagination = $this->get('Pagination');

        parent::display($tpl);
    }
}

?>

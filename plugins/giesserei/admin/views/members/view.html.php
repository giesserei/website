<?php
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

class GiessereiViewMembers extends JViewLegacy
{
    protected $items;
    protected $pagination;
    protected $state;
    protected $sortDirection;
    protected $sortColumn;

    public function display($tpl = null)
    {
        $user = JFactory::getUser();
        $canEditFull = $user->authorise('edit.member', 'com_giesserei');

        JToolBarHelper::title('Mitgliederlisten-Verwaltung', 'user.png');

        if ($canEditFull) {
            JToolBarHelper::addNew('member.add', 'JTOOLBAR_NEW');
        }

        JToolBarHelper::editList('member.edit', 'JTOOLBAR_EDIT');

        if ($canEditFull) {
            JToolBarHelper::deleteList('', 'members.delete', 'JTOOLBAR_DELETE');
        }

        $this->items = $this->get('Items');
        $this->state = $this->get('State');
        $this->pagination = $this->get('Pagination');

        $this->sortDirection = $this->state->get('list.direction');
        $this->sortColumn = $this->state->get('list.ordering');

        parent::display($tpl);
    }
}

?>

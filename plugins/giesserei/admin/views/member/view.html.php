<?php
defined('_JEXEC') or die;

class GiessereiViewMember extends JViewLegacy
{

    protected $item;

    protected $form;

    protected $canEditFull;

    public function display($tpl = null)
    {
        JFactory::getApplication()->input->set('hidemainmenu', true);
        $this->form = $this->get('Form');
        $this->item = $this->get('Item');

        $this->addToolbar();

        $user = JFactory::getUser();
        $this->canEditFull = $user->authorise('edit.member', 'com_giesserei');

        parent::display($tpl);
    }

    // -------------------------------------------------------------------------
    // private section
    // -------------------------------------------------------------------------

    private function addToolbar()
    {
        $isNew = ($this->item->userid < 1);
        $text = $isNew ? JText::_('Neu') : JText::_('Bearbeiten');
        JToolBarHelper::title('Mitglied: <small>[' . $text . ']</small>');
        JToolBarHelper::save('member.save', 'JTOOLBAR_SAVE');

        if ($isNew) {
            JToolBarHelper::cancel('member.cancel', 'Abbrechen');
        } else {
            JToolBarHelper::cancel('member.cancel', 'Schliessen');
        }
    }
}

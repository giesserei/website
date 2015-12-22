<?php
defined('_JEXEC') or die('Restricted access');

class GiessereiViewKid extends JViewLegacy
{

    protected $item;

    protected $form;

    public function display($tpl = null)
    {
        JFactory::getApplication()->input->set('hidemainmenu', true);
        $this->form = $this->get('Form');
        $this->item = $this->get('Item');

        $this->addToolbar();
        parent::display($tpl);

    }

    protected function addToolbar()
    {
        $isNew = ($this->item->id < 1);
        $text = $isNew ? JText::_('Neu') : JText::_('Bearbeiten');
        JToolBarHelper::title('Kind: <small>[' . $text . ']</small>');
        JToolBarHelper::save('kid.save', 'JTOOLBAR_SAVE');

        if ($isNew):
            JToolBarHelper::cancel('kid.cancel', 'Abbrechen');
        else:
            JToolBarHelper::cancel('kid.cancel', 'Schliessen');
        endif;

    }
}

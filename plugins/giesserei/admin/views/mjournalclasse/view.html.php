<?php
/*
 * Oktober 2013, JAL
 *
*/
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class GiessereiViewMJournalClasse extends JViewLegacy
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
        JToolBarHelper::title('Journalklasse: <small>[' . $text . ']</small>');
        JToolBarHelper::save('mjournalclasse.save', 'JTOOLBAR_SAVE');

        if ($isNew):
            JToolBarHelper::cancel('mjournalclasse.cancel', 'Abbrechen');
        else:
            JToolBarHelper::cancel('mjournalclasse.cancel', 'Schliessen');
        endif;

    }
}

?>

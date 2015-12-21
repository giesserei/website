<?php
/*
 * Oktober 2013, JAL
 *
*/
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class GiessereiViewOJournalClasse extends JViewLegacy
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
        JToolBarHelper::title('Objekt-Journalklasse: <small>[' . $text . ']</small>');
        JToolBarHelper::save('ojournalclasse.save', 'JTOOLBAR_SAVE');

        if ($isNew):
            JToolBarHelper::cancel('ojournalclasse.cancel', 'Abbrechen');
        else:
            JToolBarHelper::cancel('ojournalclasse.cancel', 'Schliessen');
        endif;

    }
}

?>

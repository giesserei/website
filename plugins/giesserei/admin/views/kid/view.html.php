<?php
defined('_JEXEC') or die('Restricted access');

class GiessereiViewKid extends JViewLegacy
{

    /**
     * @var  JForm
     */
    protected $form;

    /**
     * @var  object
     */
    protected $item;

    /**
     * @var  JObject
     */
    protected $state;

    /**
     * @var JObject
     */
    protected $canDo;

    public function display($tpl = null)
    {
        $this->form = $this->get('Form');
        $this->item = $this->get('Item');
        $this->state = $this->get('State');
        $this->canDo = JHelperContent::getActions('com_zeitbank');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            JError::raiseError(500, implode("\n", $errors));

            return false;
        }

        parent::display($tpl);
        $this->addToolbar();
    }

    protected function addToolbar()
    {
        $input = JFactory::getApplication()->input;
        $input->set('hidemainmenu', true);

        $isNew = ($this->item->id == 0);
        $canDo = $this->canDo;

        JToolbarHelper::title(JText::_($isNew ? 'Kind anlegen' : 'Kind bearbeiten'));

        // If a new item, can save the item.  Allow users with edit permissions to apply changes to prevent returning to grid.
        if ($isNew && $canDo->get('core.create')) {
            if ($canDo->get('core.edit')) {
                JToolbarHelper::apply('kid.apply');
            }

            JToolbarHelper::save('kid.save');
        }

        if (!$isNew && $canDo->get('core.edit')) {
            JToolbarHelper::apply('kid.apply');
            JToolbarHelper::save('kid.save');
        }

        if ($isNew) {
            JToolbarHelper::cancel('kid.cancel');
        } else {
            JToolbarHelper::cancel('kid.cancel', 'JTOOLBAR_CLOSE');
        }
    }
}

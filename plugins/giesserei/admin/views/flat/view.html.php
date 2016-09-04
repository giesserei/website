<?php
defined('_JEXEC') or die('Restricted access');

class GiessereiViewFlat extends JViewLegacy
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
        $this->canDo = JHelperContent::getActions('com_giesserei');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            JError::raiseError(500, implode("\n", $errors));

            return false;
        }

        parent::display($tpl);
        $this->addToolbar();
    }

    /**
     * Wohnungen können nicht neu erstellt werden - keinen Speichern-Button anbieten
     */
    protected function addToolbar()
    {
        $input = JFactory::getApplication()->input;
        $input->set('hidemainmenu', true);

        $isNew = ($this->item->id == 0);
        $canDo = $this->canDo;

        JToolbarHelper::title(JText::_($isNew
            ? 'Wohnungen können nicht erstellt werden'
            : 'Wohnung ' . $this->item->id . ' bearbeiten'));

        if (!$isNew && $canDo->get('core.edit')) {
            JToolbarHelper::apply('flat.apply');
            JToolbarHelper::save('flat.save');
        }

        if ($isNew) {
            JToolbarHelper::cancel('flat.cancel');
        } else {
            JToolbarHelper::cancel('flat.cancel', 'JTOOLBAR_CLOSE');
        }
    }

    protected function getBewohner()
    {
        return $this->getModel()->getBewohner();
    }

    protected function getKids()
    {
        return $this->getModel()->getKids();
    }
}
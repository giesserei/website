<?php
defined('_JEXEC') or die;

JLoader::register('GiessereiHelper', JPATH_COMPONENT . '/helpers/giesserei.php');

class GiessereiViewMember extends JViewLegacy
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

    /**
     * @var boolean
     */
    protected $canEditFull;

    public function display($tpl = null)
    {
        $this->form = $this->get('Form');
        $this->item = $this->get('Item');
        $this->state = $this->get('State');
        $this->canDo = JHelperContent::getActions('com_giesserei');
        $this->canEditFull = $this->canDo->get('edit.member');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            JError::raiseError(500, implode("\n", $errors));

            return false;
        }

        parent::display($tpl);
        $this->addToolbar();
    }

    protected function getMitbewohner()
    {
        return $this->getModel()->getMitbewohner();
    }

    protected function getKinder()
    {
        return $this->getModel()->getKinder();
    }

    // -------------------------------------------------------------------------
    // private section
    // -------------------------------------------------------------------------

    private function addToolbar()
    {
        $input = JFactory::getApplication()->input;
        $input->set('hidemainmenu', true);

        $isNew = ($this->item->id == 0);
        $canDo = $this->canDo;

        JToolbarHelper::title(JText::_($isNew
            ? 'Mitglied anlegen'
            : 'Mitglied bearbeiten'));

        // If a new item, can save the item.  Allow users with edit permissions to apply changes to prevent returning to grid.
        if ($isNew && $canDo->get('core.create')) {
            if ($canDo->get('core.edit')) {
                JToolbarHelper::apply('member.apply');
            }

            JToolbarHelper::save('member.save');
        }

        if (!$isNew && $canDo->get('core.edit')) {
            JToolbarHelper::apply('member.apply');
            JToolbarHelper::save('member.save');
        }

        if ($isNew) {
            JToolbarHelper::cancel('member.cancel');
        } else {
            JToolbarHelper::cancel('member.cancel', 'JTOOLBAR_CLOSE');
        }
    }
}

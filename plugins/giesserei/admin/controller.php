<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class GiessereiController extends JControllerLegacy
{

    /**
     * Method to display a view.
     *
     * @param   boolean $cachable If true, the view output will be cached
     * @param   array|boolean $urlparams An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
     *
     * @return  JController    This object to support chaining.
     */
    public function display($cachable = false, $urlparams = false)
    {
        $input = JFactory::getApplication()->input;
        $view = $input->get('view', "empty");

        if ($view === 'empty') {
            $this->setRedirect(JRoute::_('index.php?option=com_giesserei&view=default', false));
            return false;
        }

        if (!$this->isAuthorised($view)) {
            return false;
        }

        parent::display($cachable, $urlparams);

        return $this;
    }

    // -------------------------------------------------------------------------
    // private section
    // -------------------------------------------------------------------------

    private function isAuthorised($view)
    {
        $user = JFactory::getUser();
        $assetname = 'com_giesserei';

        if ($view === 'members') {
            return $user->authorise('view.member', $assetname);
        }
        if ($view === 'kids') {
            return $user->authorise('view.kid', $assetname);
        }
        if ($view === 'flats') {
            return $user->authorise('view.flat', $assetname);
        }

        return true;
    }
}
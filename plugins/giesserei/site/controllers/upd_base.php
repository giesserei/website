<?php
defined('_JEXEC') or die('Restricted access');

JLoader::register('GiessereiFrontendHelper', JPATH_COMPONENT . '/helpers/giesserei_frontend.php');
JLoader::register('GiessereiConst', JPATH_COMPONENT . '/helpers/giesserei_const.php');

/**
 * Basis-Klasse für die Controller zum Editieren des Profils eines Mitglieds.
 */
abstract class GiessereiControllerUpdBase extends JControllerForm
{

    /**
     * Führt nach ein paar Vorarbeiten einen Redirect auf die View durch, welche das Profil-Formular anzeigt.
     */
    public function edit()
    {
        GiessereiFrontendHelper::methodBegin('GiessereiControllerUpdBase', 'edit');

        if (!GiessereiFrontendHelper::checkAuth()) {
            return false;
        }

        $this->redirectEditView();

        return true;
    }

    /**
     * Speichert die Formulardaten des Profils in der Datenbank.
     */
    public function save()
    {
        GiessereiFrontendHelper::methodBegin('GiessereiControllerUpdBase', 'save');

        if (!GiessereiFrontendHelper::checkAuth()) {
            return false;
        }

        $app = JFactory::getApplication();

        // Form-Token prüfen -> Token wird in Template gesetzt
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $formData = $this->getFormData();

        // Validierung -> Validierungsmeldungen werden direkt ausgegeben
        $validateResult = $this->validateData($formData);
        if ($validateResult === false) {
            return false;
        }

        // Daten Speichern
        if ($this->processSave($validateResult)) {
            // Daten in der Session löschen
            $app->setUserState(GiessereiConst::SESSION_KEY_PROFIL_DATA, null);
            $this->redirectProfilView();
            return true;
        }

        return false;
    }

    // -------------------------------------------------------------------------
    // protected section
    // -------------------------------------------------------------------------

    /**
     * Liefert ein Array mit den Formdaten zurück, die gespeichert werden dürfen.
     * -> Verhindert, dass nicht zulässige Tabellen-Felder verändert werden.
     */
    abstract protected function filterFormFields($data);

    /**
     * Liefert true, wenn bei einer fehlgeschlagenen Validierung oder Speicherung die Daten
     * für eine Anzeige in der Session gespeichert werden sollen.
     */
    abstract protected function saveDataInSession();

    /**
     * Liefert den Namen der View.
     */
    abstract protected function getViewName();

    /**
     * Auf die Edit-View weiterleiten. Es wird auch die Menü-Id der Profilseite gesetzt, damit das Menü sich nicht verstellt.
     */
    protected function redirectEditView()
    {
        $app = JFactory::getApplication();
        $menuId = $app->getUserState(GiessereiConst::SESSION_KEY_PROFIL_MENU_ID);
        $this->setRedirect(
            JRoute::_('index.php?option=com_giesserei&view=' . $this->getViewName() . '&layout=edit&Itemid=' . $menuId, false)
        );
    }

    /**
     * Auf die Profilansicht weiterleiten.
     */
    protected function redirectProfilView()
    {
        $app = JFactory::getApplication();
        $menuId = $app->getUserState(GiessereiConst::SESSION_KEY_PROFIL_MENU_ID);
        $this->setRedirect(
            JRoute::_('index.php?option=com_giesserei&view=profil&layout=view', false)
        );
    }

    /**
     * Daten vor dem Speichern ggf. in die DB-Darstellung umformatieren.
     */
    protected function formatData($data)
    {
        return $data;
    }

    // -------------------------------------------------------------------------
    // private section
    // -------------------------------------------------------------------------

    /**
     * Holt die Formulardaten des Profilformulars aus dem JInput.
     */
    private function getFormData()
    {
        $app = JFactory::getApplication();
        $input = $app->input;
        $model = $this->getModel();
        $form = $model->getForm(array(), false);
        $data = $input->get($form->getFormControl(), '', 'array');

        return $this->filterFormFields($data);
    }

    /**
     * Prüft, ob die Eingaben korrekt sind. Sind die Eingaben nicht korrekt, werden die
     * Eingaben in der Session gespeichert, damit diese erneut angezeigt werden können.
     *
     * Validierungsmeldungen werden direkt ausgegeben.
     *
     * @return mixed  Array mit gefilterten Daten, wenn alle Daten korrekt sind; sonst false
     */
    private function validateData($data)
    {
        $app = JFactory::getApplication();
        $model = $this->getModel();
        $form = $model->getForm($data, false);

        $validateResult = $model->validate($form, $data);

        // Nur die ersten drei Fehler dem Benutzer anzeigen
        if ($validateResult === false) {
            $errors = $model->getErrors();

            for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++) {
                if ($errors[$i] instanceof Exception) {
                    $app->enqueueMessage($errors[$i]->getMessage(), 'warning');
                } else {
                    $app->enqueueMessage($errors[$i], 'warning');
                }
            }

            // Daten in der Session speichern
            if ($this->saveDataInSession()) {
                $app->setUserState(GiessereiConst::SESSION_KEY_PROFIL_DATA, $data);
            }

            // Zurück zum Formular
            $this->redirectEditView();

            return false;
        }

        return $validateResult;
    }

    /**
     * Speichert die Daten. Tritt ein Fehler auf, werden die Eingaben in der Session gespeichert,
     * damit diese erneut angezeigt werden können.
     *
     * Fehlermeldungen werden direkt angezeigt.
     *
     * @return boolean True, wenn das Speichern erfolgreich war
     */
    protected function processSave($data)
    {
        $app = JFactory::getApplication();
        $model = $this->getModel();

        $data = $this->formatData($data);

        // Fehlermeldung dem Benutzer anzeigen
        if (!$model->save($data)) {
            $errors = $model->getErrors();
            foreach ($errors as $error) {
                $app->enqueueMessage($error, 'warning');
            }

            // Daten in der Session speichern
            if ($this->saveDataInSession()) {
                $app->setUserState(GiessereiConst::SESSION_KEY_PROFIL_DATA, $data);
            }

            // Zurück zum Formular
            $this->redirectEditView();

            return false;
        }

        return true;
    }

}
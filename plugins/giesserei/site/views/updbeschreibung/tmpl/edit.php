<?php

defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');

JLoader::register('GiessereiFrontendHelper', JPATH_COMPONENT . '/helpers/giesserei_frontend.php');
echo GiessereiFrontendHelper::getScriptToHideHeaderImage();

?>

<h1 style="font-weight:bold;color: #7BA428; margin-bottom:10px;padding-bottom:0px;">
    Beschreibung ändern von <?php echo $this->item->vorname . " " . $this->item->nachname ?>
</h1>

<div class="component">

    <form
        action="<?php echo JRoute::_("index.php?option=com_giesserei&task=updbeschreibung.save&Itemid=" . $this->menuId); ?>"
        id="profilForm" name="profilForm" method="post" class="form-validate">

        <?php echo $this->form->getInput('zur_person'); ?>

        <fieldset>
            <input type="submit" value="Speichern"></button>
            <input type="button" value="Abbrechen"
                   onclick="window.location.href='<?php echo JRoute::_('index.php?option=com_giesserei&view=profil&layout=view') ?>'"/>
            <?php echo JHtml::_('form.token'); ?>
        </fieldset>
    </form>
</div>
<?php

defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');

JLoader::register('GiessereiFrontendHelper', JPATH_COMPONENT . '/helpers/giesserei_frontend.php');
echo GiessereiFrontendHelper::getScriptToHideHeaderImage();

?>

<h1 style="font-weight:bold;color: #7BA428; margin-bottom:10px;padding-bottom:0px;">
  Passwort ändern von <?php echo $this->item->vorname . " " . $this->item->nachname?>
</h1>

<div class="component">
  
	<form action="<?php echo JRoute::_("index.php?option=com_giesserei&task=updpassword.save&Itemid=".$this->menuId); ?>" 
			id="profilForm" name="profilForm" method="post" class="form-validate">
			
		<table class="user_profil">
			<tr>
			  <td class="user_profil_lb"><?php echo $this->form->getLabel('password'); ?></td>
			  <td class="user_profil_edit"><?php echo $this->form->getInput('password'); ?></td>
			</tr>	
      <tr>
        <td class="user_profil_lb"><?php echo $this->form->getLabel('password2'); ?></td>
			  <td class="user_profil_edit"><?php echo $this->form->getInput('password2'); ?></td>
      </tr>
    </table>
			
		<fieldset>
			<input type="submit" value="Speichern"></button>
			<input type="button" value="Abbrechen" 
			       onclick="window.location.href='<?php echo JRoute::_('index.php?option=com_giesserei&view=profil&layout=view')?>'" />
			<?php echo JHtml::_('form.token'); ?>
		</fieldset>	
  </form>
</div>
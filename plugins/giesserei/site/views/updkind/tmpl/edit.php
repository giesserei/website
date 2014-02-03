<?php

defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');

JLoader::register('GiessereiFrontendHelper', JPATH_COMPONENT . '/helpers/giesserei_frontend.php');
echo GiessereiFrontendHelper::getScriptToHideHeaderImage();

?>

<h1 style="font-weight:bold;color: #7BA428; margin-bottom:10px;padding-bottom:0px;">
  Profil bearbeiten von <?php echo $this->item->vorname . " " . $this->item->nachname?>
</h1>
<div style="margin-bottom:20px">
  Für Namens- und Jahrgangsänderungen schreibe bitte ein Mail an 
  <a href="mailto:kasse@giesserei-gesewo.ch">kasse@giesserei-gesewo.ch</a>
</div>

<div class="component">
  
	<form action="<?php echo JRoute::_("index.php?option=com_giesserei&task=updkind.save&Itemid=".$this->menuId); ?>" 
			id="profilForm" name="profilForm" method="post" class="form-validate">
			
		<table class="user_profil">
			<tr>
			  <td class="user_profil_lb">Vorname</td>
			  <td class="user_profil_view"><?php echo $this->item->vorname; ?></td>
			  <td>
          <span style="padding-right:10px">Sichtbar in Bewohnerliste:</span>
          <?php echo $this->form->getInput('name_frei'); ?>
        </td>
			</tr>	
      <tr>
        <td class="user_profil_lb">Nachname</td>
        <td class="user_profil_view" colspan="2"><?php echo $this->item->nachname; ?></td>
      </tr>
      <tr>
        <td class="user_profil_lb">Jahrgang</td>
        <td class="user_profil_edit"><?php echo $this->item->jahrgang; ?></td>
        <td>
          <span style="padding-right:10px">Sichtbar in Bewohnerliste:</span>
          <?php echo $this->form->getInput('jahrgang_frei'); ?>
        </td>
      </tr>
      <tr>
        <td class="user_profil_lb"><?php echo $this->form->getLabel('handy'); ?></td>
        <td class="user_profil_edit"><?php echo $this->form->getInput('handy'); ?></td>
        <td>
          <span style="padding-right:10px">Sichtbar in Bewohnerliste:</span>
          <?php echo $this->form->getInput('handy_frei'); ?>
        </td>
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
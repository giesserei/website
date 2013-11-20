<?php
/*
 * Created on 27.12.2010
 *
 */
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');

?>
<form action="<?php echo JRoute::_('index.php?option=com_giesserei&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm">

<div class="width-60 fltlft">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Journaleintrag' ); ?></legend>
		<table class="admintable">
		
			<tr><td width="100" align="right" class="key">
			<?php 	echo $this->form->getLabel('datum')."</td><td>"; 
					echo $this->form->getInput('datum');
			?>
			</td>
			</tr>
			
			<tr><td width="100" align="right" class="key">
			<?php 	echo $this->form->getLabel('beschreibung')."</td><td>"; 
					echo $this->form->getInput('beschreibung');
			?>
			</td></tr>
			
			<tr><td width="100" align="right" class="key">
			<?php 	echo "Klasse: </td><td><select id=\"jform_klasseid\" name=\"jform[klasseid]\" >"; 
					$typen = $this->get('MemberjournalClasses');
					if(count($typen) > 0):
						foreach($typen as $typ):
							echo "<option value=\"".$typ->id."\"";
							if($this->item->klasseid == $typ->id) echo " selected=\"true\"";
							echo " >".$typ->code."</option>";
						endforeach;
					endif;
			?></select>
			</td></tr>

			
						
		</table>
	</fieldset>
</div>
	<input type="hidden" name="jform[userid]" value="<?php echo $this->item->userid; ?>" />
	<input type="hidden" name="task" value="" />
	
	<?php echo JHtml::_('form.token'); ?>
</form>
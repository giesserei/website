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
		<!-- Joomla Bug Ovverride -->
		<input type="hidden" name="jform[maisonette]" value="0">
		<legend><?php echo JText::_( 'Wohnungsdetails' ); ?></legend>
		<table class="admintable">
		
			<tr><td width="100" align="right" class="key">
			<?php 	echo "Wohnungsnummer: </td><td><strong>".$this->item->id."</strong>"; 		?>
			</td>
			</tr>
			
			<tr><td width="100" align="right" class="key">
			<?php 	echo $this->form->getLabel('miete')."</td><td>"; 
					echo $this->form->getInput('miete');
			?>
			</td></tr>

			<tr><td width="100" align="right" class="key">
			<?php 	echo $this->form->getLabel('subventioniert')."</td><td>"; 
					echo $this->form->getInput('subventioniert');
			?>
			</td></tr>

			<tr><td width="100" align="right" class="key">
			<?php 	echo "Wohnungstyp: </td><td><select id=\"jform_typid\" name=\"jform[typid]\" >"; 
					$typen = $this->get('FlatTypes');
					if(count($typen) > 0):
						foreach($typen as $typ):
							echo "<option value=\"".$typ->id."\"";
							if($this->item->typid == $typ->id) echo " selected=\"true\"";
							echo " >".$typ->bezeichnung." (".$typ->zimmerbezeichnung.")</option>";
						endforeach;
					endif;
			?>
			</td></tr>

			<tr><td width="100" align="right" class="key">
			<?php 	echo $this->form->getLabel('nk')."</td><td>"; 
					echo $this->form->getInput('nk');
			?>
			</td></tr>

			<tr><td width="100" align="right" class="key">
			<?php 	echo $this->form->getLabel('nk_stadtwerk')."</td><td>"; 
					echo $this->form->getInput('nk_stadtwerk');
			?>
			</td></tr>

			<tr><td width="100" align="right" class="key">
			<?php 	echo $this->form->getLabel('pflichtdarlehen')."</td><td>"; 
					echo $this->form->getInput('pflichtdarlehen');
			?>
			</td></tr>

			<tr><td width="100" align="right" class="key">
			<?php 	echo $this->form->getLabel('flaeche')."</td><td>"; 
					echo $this->form->getInput('flaeche');
			?>
			</td></tr>

			<tr><td width="100" align="right" class="key">
			<?php 	echo $this->form->getLabel('maisonette')."</td><td>"; 
					echo $this->form->getInput('maisonette');
			?>
			</td></tr>

			<tr><td width="100" align="right" class="key">
			<?php 	echo $this->form->getLabel('grundriss')."</td><td>"; 
					echo $this->form->getInput('grundriss');
			?>
			</td></tr>

			<tr><td width="100" align="right" class="key">
			<?php 	echo $this->form->getLabel('anmerkung')."</td><td>"; 
					echo $this->form->getInput('anmerkung');
			?>
			</td></tr>

			<tr><td width="100" align="right" class="key">
			<?php 	echo $this->form->getLabel('freiab')."</td><td>"; 
					echo $this->form->getInput('freiab');
			?>
			</td></tr>

			<tr><td width="100" align="right" class="key">
			<?php 	echo $this->form->getLabel('nasszellen')."</td><td>"; 
					echo $this->form->getInput('nasszellen');
			?>
			</td></tr>

			<tr><td width="100" align="right" class="key">
			<?php 	echo $this->form->getLabel('reduit')."</td><td>"; 
					echo $this->form->getInput('reduit');
			?>
			</td></tr>

			<tr><td width="100" align="right" class="key">
			<?php 	echo $this->form->getLabel('mietvertrag_beginn')."</td><td>"; 
					echo $this->form->getInput('mietvertrag_beginn');
			?>
			</td></tr>

			<tr><td width="100" align="right" class="key">
			<?php 	echo $this->form->getLabel('gewerbe_flaeche')."</td><td>"; 
					echo $this->form->getInput('gewerbe_flaeche');
			?>
			</td></tr>

			<tr><td width="100" align="right" class="key">
			<?php 	echo $this->form->getLabel('oto')."</td><td>"; 
					echo $this->form->getInput('oto');
			?>
			</td></tr>


						
		</table>
	</fieldset>
	
</div>

<div class="width-40 fltrt">
<?php echo JHtml::_('sliders.start', 'Bewohnerschaft'); ?>
<?php echo JHtml::_('sliders.panel',JText::_('Bewohnerschaft'), 'telefonie'); ?>
	<fieldset class="panelform">
    	<ul>
        <?php
			$bewohner = $this->get('Bewohner');
			if(count($bewohner) > 0):
				foreach($bewohner as $bew):
					echo "<li><a href=\"/administrator/index.php?option=com_giesserei&task=member.edit&id=".$bew->id."\">".$bew->vorname." ".$bew->nachname."</a></li>";
				endforeach;
			endif;        
        ?>
            
    	</ul>
    	<ul>
        <li><?php
			$kids = $this->get('Kids');
			if(count($kids) > 0):
				echo "mit Kind(ern): ";
				foreach($kids as $kid):
					echo "<a href=\"/administrator/index.php?option=com_giesserei&task=kid.edit&id=".$kid->id."\">".$kid->vorname." ".$kid->nachname."</a>";
					if($kid != end($kids)) echo ", ";
				endforeach;
			endif;        
        ?></li>    	
    	</ul>
	</fieldset>
</div>
<?php echo JHtml::_('sliders.end'); ?>

<div class="width-40 fltrt">
<?php echo JHtml::_('sliders.start', 'extern', $params=array('display'=>-1,'show'=>-1,'seCookie'=>false,'startOffset'=>-1,'startTransition'=>true)); ?>
<?php echo JHtml::_('sliders.panel',JText::_('Journal'), 'extern'); ?>
	<fieldset class="panelform">
    	<ul>
        <?php
			$journal = $this->get('Journal');
			if(count($journal) > 0):
				echo "<li><table>";
				foreach($journal as $jeintrag):
					echo "<tr><td>".$jeintrag->datum."</td><td width=\"10\" style=\"background-color: #".$jeintrag->farbe."\"></td>"
						."<td><a href=\"/administrator/index.php?option=com_giesserei&task=ojournal.edit&id=".$jeintrag->id."\">".$jeintrag->titel."</a></td></tr>";
				endforeach;   
				echo "</table></li>";
			else:
				echo "<li>(keine Journaleinträge)</li>";
			endif;        
        ?>            
        <li><a href="/administrator/index.php?option=com_giesserei&view=ojournal&layout=edit&objektid=<?php echo $this->item->id; ?>">Neuen Journaleintrag vornehmen</a></li>
    	</ul>

	</fieldset>
</div>

<?php echo JHtml::_('sliders.end'); ?>

	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>
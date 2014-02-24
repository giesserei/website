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
		<legend><?php echo JText::_( 'Personalien' ); ?></legend>
		<table class="admintable">
		
			<tr><td width="80" align="right" class="key">
			<?php 	echo $this->form->getLabel('vorname')."</td><td>"; 
					echo $this->form->getInput('vorname');
			?>
			</td>
			</tr>
			
			<tr><td width="80" align="right" class="key">
			<?php 	echo $this->form->getLabel('nachname')."</td><td>"; 
					echo $this->form->getInput('nachname');
			?>
			</td></tr>

			<tr><td width="80" align="right" class="key">
			<?php 	echo $this->form->getLabel('adresse')."</td><td>"; 
					echo $this->form->getInput('adresse');
			?>
			</td></tr>

			<tr><td width="80" align="right" class="key">
			<?php 	echo $this->form->getLabel('plz')."</td><td>"; 
					echo $this->form->getInput('plz');
			?>
			</td></tr>
			
			<tr><td width="80" align="right" class="key">
			<?php 	echo $this->form->getLabel('ort')."</td><td>"; 
					echo $this->form->getInput('ort');
			?>
			</td></tr>
						
			<tr><td width="80" align="right" class="key">
			<?php 	echo $this->form->getLabel('jahrgang')."</td><td>"; 
					echo $this->form->getInput('jahrgang'); 
					// Vergleich des Jahrgang mit dem angegebenen Geburtstag in Kunena-Forum
					if($this->item->jahrgang != JHTML::date($this->item->birthdate,'Y') && strlen($this->item->birthdate)>4 ):
						echo "<span style=\"color: red; font-weight:bold; font-size:15pt;\">!!</span>";
					endif;
			?>

			</td></tr>
						
			<tr><td width="80" align="right" class="key">
			<?php 	echo $this->form->getLabel('userid')."</td><td>"; 
					echo $this->form->getInput('userid');
			?>
			</td></tr>

			<tr><td width="80" align="right" class="key">
			<?php 	echo $this->form->getLabel('zur_person')."</td><td>"; 
					echo $this->form->getInput('zur_person');
			?>
			</td></tr>

		</table>
	</fieldset>
</div>

<div class="width-40 fltrt">
<?php echo JHtml::_('sliders.start', 'verarbeitung'); ?>
<?php echo JHtml::_('sliders.panel', 'Automatische Verarbeitung', 'verarbeitung'); ?>
	<fieldset class="panelform">
   	<ul class="adminformlist">
      <li>
			  <?php echo $this->form->getLabel('is_update_user_name'); 
				  	  echo $this->form->getInput('is_update_user_name'); ?>
      </li>
      <li>
			  <?php echo $this->form->getLabel('is_update_permission'); 
				  	  echo $this->form->getInput('is_update_permission'); ?>
      </li>
     </ul>
	</fieldset>
</div>
<?php echo JHtml::_('sliders.end'); ?>

<div class="width-40 fltrt">
<?php echo JHtml::_('sliders.start', 'Telefonie'); ?>
<?php echo JHtml::_('sliders.panel',JText::_('Telefonie-Daten'), 'telefonie'); ?>
	<fieldset class="panelform">
	<!-- Joomla Bug Ovverride -->
	<input type="hidden" name="jform[telefon_frei]" value="0">
	<input type="hidden" name="jform[handy_frei]" value="0">
    	<ul class="adminformlist">
            <li>
			<?php 	echo $this->form->getLabel('telefon'); 
					echo $this->form->getInput('telefon');
					echo $this->form->getLabel('telefon_frei').$this->form->getInput('telefon_frei');
			?>
            </li>
            <li>
			<?php 	echo $this->form->getLabel('handy'); 
					echo $this->form->getInput('handy');
					echo $this->form->getLabel('handy_frei').$this->form->getInput('handy_frei');
			?>
            </li>
    	</ul>
	</fieldset>
</div>
<?php echo JHtml::_('sliders.end'); ?>


<div class="width-40 fltrt">
<?php echo JHtml::_('sliders.start', 'vereinsdaten' ); ?>
<?php echo JHtml::_('sliders.panel',JText::_('Vereinsdaten'), 'verein'); ?>
	<fieldset class="panelform">
    <ul class="adminformlist">
      <li>
			  <?php echo $this->form->getLabel('wohnung'); 
					    echo $this->form->getInput('wohnung'); ?>
      </li>
      <li>
			  <?php echo $this->form->getLabel('funktion'); 
					    echo $this->form->getInput('funktion'); ?>
      </li>
      <li>
			  <?php echo $this->form->getLabel('eintritt'); 
					    echo $this->form->getInput('eintritt'); ?>
      </li>
      <li>
			  <?php echo $this->form->getLabel('austritt'); 
					    echo $this->form->getInput('austritt'); ?>
      </li>
      <li>
			  <?php echo $this->form->getLabel('einzug'); 
					    echo $this->form->getInput('einzug'); ?>
      </li>
      <li>
			  <?php echo $this->form->getLabel('typ'); 
					    echo $this->form->getInput('typ'); ?>
      </li>
      <li>
			  <?php echo $this->form->getLabel('dispension_grad'); 
					    echo $this->form->getInput('dispension_grad'); ?>
      </li>
      <li>
			  <?php echo $this->form->getLabel('kommentar'); 
					    echo $this->form->getInput('kommentar'); ?>
      </li>
    </ul>
	</fieldset>
</div>
<?php echo JHtml::_('sliders.end'); ?>

<div class="width-40 fltrt">
<?php echo JHtml::_('sliders.start', 'extern', $params=array('display'=>-1,'show'=>-1,'seCookie'=>false,'startOffset'=>-1,'startTransition'=>true)); ?>
<?php echo JHtml::_('sliders.panel',JText::_('Daten aus anderen Tabellen'), 'extern'); ?>
	<fieldset class="panelform">
	<table>
  		<tr><td>Kinder: </td><td><strong><?php echo $this->item->kinder; ?></strong></td></tr>
  		<tr><td>E-Mail: </td><td><strong><?php echo $this->item->email; ?></strong></td></tr>
  		<tr><td>Gruppen: </td><td><strong><?php echo $this->item->gruppen; ?></strong></td></tr>
  		<tr><td>Geburtstag: </td><td><strong><?php 
  			if(strlen($this->item->birthdate) > 4):
  				echo JHTML::date($this->item->birthdate,'d.m.Y'); 
  			else:
  				echo "kein Datum angegeben";
  			endif;
  			?></strong></td></tr>
  		<tr><td>Website: </td><td><strong><?php  
  			if(strlen($this->item->websiteurl) > 5):
  				if(strlen($this->item->websitename) < 3) $ithis->item->websitename = $this->item->websiteurl;
  				echo "<a href=\"http://".$this->item->websiteurl."\">".$this->item->websitename."</a>"; 
  			else:
  				echo "keine Website";
  			endif;	
  			?></strong></td></tr>
  		<tr><td>Geschlecht: </td><td><strong><?php  if($this->item->gender == 1) echo "männlich"; elseif($this->item->gender == 2) echo "weiblich"; else echo "unbekannt"; ?></strong></td></tr>
 		<tr><td colspan="2"><?php
  				if(strlen($this->item->avatar) > 5):
					echo "<img src=\"/media/kunena/avatars/".$this->item->avatar."\" alt=\"Portätfoto\" border=\"0\" />";
				else:
					echo "<img src=\"/media/kunena/avatars/resized/size200/nophoto.jpg\" alt=\"leider kein Portätfoto\" border=\"0\" />";
				endif;			
  		
  		?></td></tr>
	</table>
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
						."<td><a href=\"/administrator/index.php?option=com_giesserei&task=mjournal.edit&id=".$jeintrag->id."\">".$jeintrag->beschreibung."</a></td></tr>";
				endforeach;   
				echo "</table></li>";
			else:
				echo "<li>(keine Journaleinträge)</li>";
			endif;        
        ?>            
        <li><a href="/administrator/index.php?option=com_giesserei&view=mjournal&layout=edit&userid=<?php echo $this->item->userid; ?>">Neuen Journaleintrag vornehmen</a></li>
    	</ul>

	</fieldset>
</div>

<?php echo JHtml::_('sliders.end'); ?>
	
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>
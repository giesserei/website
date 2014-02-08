<?php
/**
 * View der Mitgliedertabelle.
 * 
 * Changes:
 * - Refactoring + Format + Comments (SF, 2013-12-29)
 * - Filter eingebaut (SF, 2013-12-29)
 * - Wohnung und Art der Mitgliedschaft in Liste anzeigen (SF, 2013-12-29)
 * 
 * @author JAL, created on 27.12.2010
 */
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.tooltip');
JHtml::_('behavior.multiselect');
?>

<form action="<?php echo JRoute::_('index.php?option=com_giesserei&view=members');?>" method="POST" name="adminForm" id="adminForm">

  <fieldset id="filter-bar">
    <!-- Suchfeld Vorname/Name -->
    <div class="filter-search fltlft">
      <label class="filter-search-lbl" for="filter_search">Mitglied suchen:&nbsp;&nbsp;</label>
      <input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="Vorname oder Nachname suchen" />
      <button type="submit">Suchen</button>
      <button type="button" onclick="document.id('filter_search').value='';this.form.submit();">Zurücksetzen</button>
    </div>
    
    <!-- Filter für Datenqualität -->
    <div class="filter-select fltrt">
      <?php
      $quality = array(
          1 => '- Datenqualität wählen -', 
          2 => 'Bewohner/Gewerbe ohne Einzugsdatum', 
          3 => 'Keine eMail-Adresse', 
          4 => 'Bewohner/Gewerbe mit fehlerhafter Adresse', 
          5 => 'Bewohner/Gewerbe ohne Wohnung',
          6 => 'Passivmitglied ausgetreten');
      $options = array();

      foreach($quality as $key=>$value) {
	      $options[] = JHTML::_('select.option', $key, $value);
      }
      
      $dropdownQuality = JHTML::_('select.genericlist', $options, 'filter_quality', 
              array('class'=>'inputbox', 'onchange'=>'this.form.submit()'), 'value', 'text', $this->state->get('filter.quality'));

      echo $dropdownQuality;
      ?>
    </div>
    
    <!-- Filter für Status -->
    <div class="filter-select fltrt">
      <?php
      $status = array(1 => '- Status wählen -', 2 => 'Mitglied', 3 => 'Ausgetreten/Ausgezogen');
      $options = array();

      foreach($status as $key=>$value) {
	      $options[] = JHTML::_('select.option', $key, $value);
      }
      
      $dropdownStatus = JHTML::_('select.genericlist', $options, 'filter_status', 
              array('class'=>'inputbox', 'onchange'=>'this.form.submit()'), 'value', 'text', $this->state->get('filter.status'));

      echo $dropdownStatus;
      ?>
    </div>
    
    <!-- Filter für Typ -->
    <div class="filter-select fltrt">
      <?php
      $typ = array(1 => '- Typ wählen -', 2 => 'Bewohner', 3 => 'Gewerbe', 4 => 'Passivmitglied', 5 => 'Passivmitglied deaktiviert');
      $options = array();

      foreach($typ as $key=>$value) {
	      $options[] = JHTML::_('select.option', $key, $value);
      }
      
      $dropdownTyp = JHTML::_('select.genericlist', $options, 'filter_typ', 
              array('class'=>'inputbox', 'onchange'=>'this.form.submit()'), 'value', 'text', $this->state->get('filter.typ'));

      echo $dropdownTyp;
      ?>
    </div>
  </fieldset>
  <div class="clr"> </div>

  <div id="editcell">
    <table class="adminlist">
    <thead>
      <tr>
        <th width="20">
          <input type="checkbox" name="checkall-toggle" value="" onclick="checkAll(this);" />
        </th>
        <th width="5">ID</th>
        <th><?php echo JHTML::_('grid.sort', 'Vorname', 'mgl.vorname', $this->sortDirection, $this->sortColumn); ?></th>
        <th><?php echo JHTML::_('grid.sort', 'Nachname', 'mgl.nachname', $this->sortDirection, $this->sortColumn); ?></th>
        <th>Adresse</th>
        <th>PLZ/Ort</th>
        <th>E-Mail</th>
        <th>Telefon</th>
        <th>Wohnung</th>
        <th><?php echo JHTML::_('grid.sort', 'Mitgliedschaft', 'mgl.typ', $this->sortDirection, $this->sortColumn); ?></th>
       </tr>
    </thead>
    <tfoot><tr><td colspan="10"><?php echo $this->pagination->getListFooter(); ?></td></tr></tfoot>
    <?php
    foreach ($this->items as $i => $item) {
      $row =& $item;
      $checked = JHTML::_('grid.id', $i, $item->id);
      $link = JRoute::_(
         'index.php?option=com_giesserei'
         .'&task=member.edit'
         .'&id='. $row->id);
      $styleStatus = $row->status == 0 ? 'style="background-color:rgb(255,154,61)"' : '';
    ?>
    <tr class="row<?php echo $i % 2; ?>">
      <td><?php echo $checked; ?></td>
      <td <?php echo $styleStatus; ?>><?php echo $row->userid; ?></td>
      <td><a href="<?php echo $link; ?>"><?php echo $row->vorname; ?></a></td>
      <td><a href="<?php echo $link; ?>"><?php echo $row->nachname; ?></a></td>
      <td><?php echo $row->adresse; ?></td>
      <td><?php echo $row->plz." ".$row->ort; ?></td>
      <td><?php echo $row->email; ?></td>
      <td><?php echo $row->telefon; ?></td>
      <td><?php echo $row->wohnung; ?></td>
      <td><?php echo $row->typ_name; ?></td>
    </tr>
    <?php
    }
    ?>
    </table>
  </div>
  <input type="hidden" name="task" value="" />
  <input type="hidden" name="view" value="members" />
  <input type="hidden" name="filter_order" value="<?php echo $this->sortColumn; ?>" />
  <input type="hidden" name="filter_order_Dir" value="<?php echo $this->sortDirection; ?>" />
  <input type="hidden" name="boxchecked" value="0" />
  <?php echo JHtml::_('form.token'); ?>
</form>
<?php
/*
 * Created on 27.12.2010
 *
 */
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.tooltip');
JHtml::_('behavior.multiselect');
// $nullDate = JFactory::getDbo()->getNullDate();

$listOrder = $this->state->get('list.ordering');
$listDirn = $this->state->get('list.direction');

if (date('n') < 7):  // Vereinswechel auf 1. Juli (7. Monat)
    $vjahr = date('Y') - 1;
else:
    $vjahr = date('Y');
endif;
$vereinsjahrstart = strtotime($vjahr . '-07-01');

?>

<form action="<?php
echo JRoute::_('index.php?option=com_giesserei&view=mjournalclasses');

?>" method="POST" name="adminForm" id="adminForm">
    <div id="editcell">
        <table class="adminlist">
            <thead>
            <tr>
                <th width="20">
                    <input type="checkbox" name="checkall-toggle" value=""
                           onclick="checkAll(this);"/>

                </th>
                <th width="5">ID</th>
                <th>Code</th>
                <th>Beschreibungstext</th>
                <th>Farbe</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <td colspan="9"><?php echo $this->pagination->getListFooter(); ?></td>
            </tr>
            </tfoot>
            <?php
            $k = 0;
            foreach ($this->items as $i => $item):
                //for ($i=0, $n=count( $this->items ); $i < $n; $i++) {
                $row =& $item;
                $checked = JHTML::_('grid.id', $i, $item->id);
                $link = JRoute::_(
                    'index.php?option=com_giesserei'
                    . '&task=mjournalclasse.edit'
                    . '&id=' . $row->id);
                ?>
                <tr class="row<?php echo $i % 2; ?>">
                    <td><?php echo $checked; ?></td>
                    <td><?php echo $row->id; ?></td>
                    <td><a href="<?php echo $link; ?>">
                            <?php echo $row->code; ?></a></td>
                    <td><?php echo $row->text; ?></td>
                    <td style="background-color: #<?php echo $row->farbe; ?>;">&nbsp;</td>
                </tr>
                <?php
                $k = 1 - $k;
            endforeach;
            ?>
        </table>
    </div>
    <input type="hidden" name="task" value=""/>
    <input type="hidden" name="boxchecked" value="0"/>
    <?php echo JHtml::_('form.token'); ?>
</form>

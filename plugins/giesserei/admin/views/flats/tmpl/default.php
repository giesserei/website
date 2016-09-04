<?php

defined('_JEXEC') or die('Restricted access');

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$user = JFactory::getUser();
$app = JFactory::getApplication();
$userId = $user->get('id');
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn = $this->escape($this->state->get('list.direction'));

?>

<form action="<?php echo JRoute::_('index.php?option=com_giesserei&view=flats'); ?>" method="post" name="adminForm"
      id="adminForm">

    <?php if (!empty($this->sidebar)) : ?>
    <div id="j-sidebar-container" class="span2">
        <?php echo $this->sidebar; ?>
    </div>
    <div id="j-main-container" class="span10">
        <?php else : ?>
        <div id="j-main-container">
            <?php endif; ?>

            <?php
            // Search tools bar
            echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this), null, array('debug' => false));
            ?>
            <?php if (empty($this->items)) : ?>
                <div class="alert alert-no-items">
                    <?php echo JText::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
                </div>
            <?php else : ?>
                <table class="table table-striped" id="kategorienList">
                    <thead>
                    <tr>
                        <th width="1%" class="center">
                            <?php echo JHtml::_('grid.checkall'); ?>
                        </th>
                        <th width="5%" class="center">
                            <?php echo JHtml::_('searchtools.sort', 'ID', 'mo.id', $listDirn, $listOrder); ?>
                        </th>
                        <th width="20%" class="title">
                            <?php echo JHtml::_('searchtools.sort', 'Typ', 'wohnung_typ', $listDirn, $listOrder); ?>
                        </th>
                        <th width="10%" style="text-align: right">
                            <?php echo JHtml::_('searchtools.sort', 'Fläche', 'mo.flaeche', $listDirn, $listOrder); ?>
                        </th>
                        <th width="10%" style="text-align: right">
                            Miete
                        </th>
                        <th width="10%" style="text-align: right">
                            Subv. Miete
                        </th>
                        <th width="10%" style="text-align: right">
                            Pflichtdarlehen
                        </th>
                        <th width="10%" style="text-align: right">
                            Nebenkosten
                        </th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <td colspan="8">
                            <?php echo $this->pagination->getListFooter(); ?>
                        </td>
                    </tr>
                    </tfoot>

                    <tbody>
                    <?php foreach ($this->items as $i => $item) {
                        $canEdit = $user->authorise('core.edit', 'com_giesserei');
                        ?>
                        <tr class="row<?php echo $i % 2; ?>">
                            <td class="center">
                                <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                            </td>
                            <td class="center">
                                <?php echo $item->id; ?>
                            </td>
                            <td class="nowrap">
                                <?php if ($canEdit) : ?>
                                    <a href="<?php echo JRoute::_('index.php?option=com_giesserei&task=flat.edit&id=' . (int)$item->id); ?>">
                                        <?php echo $this->escape($item->wohnung_typ); ?></a>
                                <?php else : ?>
                                    <?php echo $this->escape($item->wohnung_typ); ?>
                                <?php endif; ?>
                            </td>
                            <td class="nowrap" style="text-align: right">
                                <?php echo $item->flaeche; ?> m
                            </td>
                            <td class="nowrap" style="text-align: right">
                                Fr. <?php echo number_format($item->miete, 0, ',', '\''); ?>.-
                            </td>
                            <td class="nowrap" style="text-align: right">
                                Fr. <?php echo number_format($item->subventioniert, 0, ',', '\''); ?>.-
                            </td>
                            <td class="nowrap" style="text-align: right">
                                Fr. <?php echo number_format($item->pflichtdarlehen, 0, ',', '\''); ?>.-
                            </td>
                            <td class="nowrap" style="text-align: right">
                                Fr. <?php echo number_format($item->nk, 0, ',', '\''); ?>.-
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            <?php endif; ?>

        </div>
        <input type="hidden" name="task" value=""/>
        <input type="hidden" name="boxchecked" value="0"/>
        <?php echo JHtml::_('form.token'); ?>

</form>
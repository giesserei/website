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
<form action="<?php echo JRoute::_('index.php?option=com_giesserei&id=' . (int)$this->item->id); ?>" method="post"
      name="adminForm" id="adminForm">

    <div class="width-60 fltlft">
        <fieldset class="adminform">
            <legend><?php echo JText::_('Details Objektjournal-Klasse'); ?></legend>
            <table class="admintable">

                <tr>
                    <td width="100" align="right" class="key">
                        <?php echo $this->form->getLabel('code') . "</td><td>";
                        echo $this->form->getInput('code');
                        ?>
                    </td>
                </tr>

                <tr>
                    <td width="100" align="right" class="key">
                        <?php echo $this->form->getLabel('text') . "</td><td>";
                        echo $this->form->getInput('text');
                        ?>
                    </td>
                </tr>

                <tr>
                    <td width="100" align="right" class="key">
                        <?php echo $this->form->getLabel('farbe') . "</td><td>";
                        echo $this->form->getInput('farbe');

                        ?>
                    </td>
                </tr>

            </table>
        </fieldset>
    </div>


    <input type="hidden" name="task" value=""/>
    <?php echo JHtml::_('form.token'); ?>
</form>
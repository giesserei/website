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
            <input type="hidden" name="jform[jahrgang_frei]" value="0">
            <input type="hidden" name="jform[handy_frei]" value="0">
            <legend><?php echo JText::_('Personalien'); ?></legend>
            <table class="admintable">

                <tr>
                    <td width="100" align="right" class="key">
                        <?php echo $this->form->getLabel('vorname') . "</td><td>";
                        echo $this->form->getInput('vorname');
                        ?>
                    </td>
                </tr>

                <tr>
                    <td width="100" align="right" class="key">
                        <?php echo $this->form->getLabel('nachname') . "</td><td>";
                        echo $this->form->getInput('nachname');
                        ?>
                    </td>
                </tr>

                <tr>
                    <td width="100" align="right" class="key">
                        <?php echo $this->form->getLabel('jahrgang') . "</td><td>";
                        echo $this->form->getInput('jahrgang');

                        ?>
                    </td>
                </tr>

                <tr>
                    <td width="100" align="right" class="key">
                        <?php
                        echo $this->form->getLabel('jahrgang_frei') . "</td><td>";
                        echo $this->form->getInput('jahrgang_frei');
                        ?>
                    </td>
                </tr>

                <tr>
                    <td width="100" align="right" class="key">
                        <?php echo $this->form->getLabel('handy') . "</td><td>";
                        echo $this->form->getInput('handy');
                        ?>
                    </td>
                </tr>

                <tr>
                    <td width="100" align="right" class="key">
                        <?php
                        echo $this->form->getLabel('handy_frei') . "</td><td>";
                        echo $this->form->getInput('handy_frei');
                        ?>
                    </td>
                </tr>


                <tr>
                    <td width="100" align="right" class="key">
                        <?php echo $this->form->getLabel('objektid') . "</td><td>";
                        echo $this->form->getInput('objektid');
                        ?>
                    </td>
                </tr>

            </table>
        </fieldset>
    </div>


    <input type="hidden" name="task" value=""/>
    <?php echo JHtml::_('form.token'); ?>
</form>
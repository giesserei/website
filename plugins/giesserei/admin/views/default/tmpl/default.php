<?php

defined('_JEXEC') or die();

?>

<form action="<?php echo JRoute::_('index.php?option=com_giesserei&view=default'); ?>" method="post" name="adminForm"
      id="adminForm">


    <div id="j-sidebar-container" class="span2">
        <?php echo $this->sidebar; ?>
    </div>
    <div id="j-main-container" class="span10">
    </div>

    <input type="hidden" name="task" value=""/>
    <input type="hidden" name="boxchecked" value="0"/>
    <?php echo JHtml::_('form.token'); ?>

</form>
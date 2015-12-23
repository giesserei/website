<?php
defined('_JEXEC') or die('Restricted access');

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

JHtml::_('behavior.core');
JHtml::_('behavior.tabstate');
JHtml::_('behavior.formvalidator');
JHtml::_('formbehavior.chosen', 'select');

// ohne dieses Script funktionieren die Buttons der Toolbar nicht
JFactory::getDocument()->addScriptDeclaration('
	Joomla.submitbutton = function(task)
	{
		Joomla.submitform(task, document.getElementById("item-form"));
	};
');

?>

<form action="<?php echo JRoute::_('index.php?option=com_giesserei&layout=edit&id=' . (int)$this->item->id); ?>"
      method="post" name="adminForm" id="item-form" class="form-validate">

    <div class="form-horizontal">

        <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'personalien')); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'personalien', JText::_('Personalien', true)); ?>
        <?php echo $this->form->renderFieldset('personalien'); ?>
        <?php echo JHtml::_('bootstrap.endTab'); ?>

        <?php echo JHtml::_('bootstrap.endTabSet'); ?>
    </div>

    <input type="hidden" name="task" value=""/>
    <?php echo $this->form->getInput('component_id'); ?>
    <?php echo JHtml::_('form.token'); ?>
    <input type="hidden" id="fieldtype" name="fieldtype" value=""/>
</form>
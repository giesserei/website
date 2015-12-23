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
        <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'eigenschaften')); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'eigenschaften', 'Eigenschaften'); ?>
        <?php echo $this->form->renderFieldset('eigenschaften'); ?>
        <?php echo JHtml::_('bootstrap.endTab'); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'kosten', 'Kosten'); ?>
        <?php echo $this->form->renderFieldset('kosten'); ?>
        <?php echo JHtml::_('bootstrap.endTab'); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'vermietung', 'Vermietung'); ?>
        <?php echo $this->form->renderFieldset('vermietung'); ?>
        <?php echo JHtml::_('bootstrap.endTab'); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'bewohner', 'Bewohner'); ?>

        <ul>
            <?php
            $bewohner = $this->getBewohner();
            if (count($bewohner) > 0):
                foreach ($bewohner as $bew):
                    $link = JRoute::_('index.php?option=com_giesserei&task=member.edit&id=' . (int)$bew->id);
                    echo '<li><a href="' . $link . '">' . $bew->vorname . ' ' . $bew->nachname . '</a></li>';
                endforeach;
            endif;
            ?>

        </ul>
        <?php
        $kids = $this->getKids();
        if (count($kids) > 0)
        {
            echo 'Mit Kindern:';
        }
        ?>
        <ul>
            <?php
            if (count($kids) > 0):
                foreach ($kids as $kid):
                    $link = JRoute::_('index.php?option=com_giesserei&task=kid.edit&id=' . (int)$kid->id);
                    echo '<li><a href="' . $link . '">' . $kid->vorname . ' ' . $kid->nachname . '</a></li>';
                endforeach;
            endif;
            ?>
        </ul>

        <?php echo JHtml::_('bootstrap.endTab'); ?>

        <?php echo JHtml::_('bootstrap.endTabSet'); ?>
    </div>

    <input type="hidden" name="task" value=""/>
    <?php echo $this->form->getInput('component_id'); ?>
    <?php echo JHtml::_('form.token'); ?>
    <input type="hidden" id="fieldtype" name="fieldtype" value=""/>
</form>
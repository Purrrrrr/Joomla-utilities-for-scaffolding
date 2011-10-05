<?php
defined('_JEXEC') or die;
?>

<script type="text/javascript">
	Joomla.submitbutton = function(task, type)
	{
		if (task == 'item.cancel' || document.formvalidator.isValid(document.id('item-form'))) {
			Joomla.submitform(task, document.id('item-form'));
    }
  }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_emptyadmin&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="item-form" class="form-validate">

<div class="width-60 fltlft">
	<fieldset class="adminform">
		<legend><?php echo JText::_('COM_MENUS_ITEM_DETAILS');?></legend>

    <ul class="adminformlist">
      <?php foreach ($this->form->getFieldset('main') as $field): ?>
      <li>
        <?php echo $field->label; ?>
        <?php echo $field->input; ?>
      </li>
      <?php endforeach; ?>
    </ul>
	</fieldset>
</div>
</form>



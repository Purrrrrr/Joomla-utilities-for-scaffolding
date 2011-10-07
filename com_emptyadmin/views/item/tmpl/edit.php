<?php
defined('_JEXEC') or die;
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.modal');
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task, type)
  { 
		if (task == 'item.cancel' || document.formvalidator.isValid(document.id('item-form'))) {
			Joomla.submitform(task, document.id('item-form'));
    }
  }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_emptyadmin&view=item&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="item-form" class="form-validate">

  <div class="width-60 fltlft">
    <?php foreach($this->form->getFieldsets() as $fieldset): ?>
    <fieldset class="adminform">
      <legend><?php echo $fieldset->label;?></legend>

      <ul class="adminformlist">
        <?php foreach ($this->form->getFieldset($fieldset->name) as $field): ?>
        <li>
          <?php echo $field->label; ?>
          <?php echo $field->input; ?>
        </li>
        <?php endforeach; ?>
      </ul>
    </fieldset>
    <?php endforeach; ?>
    <?php echo JHtml::_('form.token'); ?>
    <input type="hidden" name="task" value="" />
  </div>
</form>

<?php
// no direct access
defined('_JEXEC') or die;

JHtml::_('behavior.multiselect');
?>
<form action="<?php echo JRoute::_('index.php?option=com_emptyadmin&view=emptyadmins');?>" method="post" name="adminForm" id="adminForm">
	<table class="adminlist">
		<thead>
			<tr>
				<th width="1%">
					<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
				</th>
        <th>
          Name
				</th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach ($this->items as $i => $item) :
			?>
			<tr class="row<?php echo $i % 2; ?>">
				<td class="center">
					<?php echo JHtml::_('grid.id', $i, $item->id); ?>
				</td>
				<td>
          <a href="<?php echo JRoute::_('index.php?option=com_emptyadmin&task=item.edit&id='.(int) $item->id);?>">
            <?php echo $item->name; ?>
          </a>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<div>
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>

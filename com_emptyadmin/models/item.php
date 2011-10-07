<?php
// No direct access
defined('_JEXEC') or die;

// Include dependancies.
jimport('joomla.application.component.modeladmin');

class EmptyadminModelItem extends JModelAdmin
{
	protected function canDelete($record)
  {
    return true;
	}
	protected function canSave($data = array(), $key = 'id')
	{
		return true;
	}

	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_emptyadmin.item', 'item', array('control' => 'jform', 'load_data' => $loadData), true);
		if (empty($form)) {
			return false;
		}
		return $form;
	}
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		return array_merge((array)$this->getItem(), (array)JFactory::getApplication()->getUserState('com_emptyadmin.edit.item.data', array()));
	}

	public function getItem($pk = null)
  {
    return parent::getItem($pk);
	}

	public function getTable($type = 'Items', $prefix = 'EmptyadminTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	protected function populateState()
  {
    parent::populateState();
	}

	protected function preprocessForm(JForm $form, $data)
	{
		parent::preprocessForm($form, $data);
	}

	public function save($data)
  {
    parent::save($data);
	}

}

<?php
// No direct access
defined('_JEXEC') or die;

// Include dependancies.
jimport('joomla.application.component.modeladmin');

class EmptyadminModelEmptyitem extends JModelAdmin
{
	protected function canDelete($record)
  {
    return parent::canDelete($record);
	}

	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
    $form = $this->loadForm('com_emptyadmin.emptyitem', 'emptyitem', array('control' => 'jform', 'load_data' => $loadData), true);
		if (empty($form)) {
			return false;
		}
		return $form;
	}
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		return array_merge((array)$this->getItem(), (array)JFactory::getApplication()->getUserState('com_emptyadmin.edit.emptyitem.data', array()));
	}

	public function getItem($pk = null)
  {
    return parent::getItem($pk);
	}

	public function getTable($type = 'Emptyitems', $prefix = 'EmptyadminTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	protected function populateState()
  {
    return parent::populateState();
	}

	protected function preprocessForm(JForm $form, $data)
	{
		return parent::preprocessForm($form, $data);
	}

	public function save($data)
  {
    return parent::save($data);
	}

}

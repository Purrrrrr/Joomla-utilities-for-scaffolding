<?php
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

class EmptyadminModelEmptyitems extends JModelList
{

	protected function populateState($ordering = null, $direction = null)
	{
		parent::populateState('id', 'asc');
    $this->setState("list.limit", 0);
	}
	protected function getListQuery()
	{
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
		$query->select('*');
		$query->from('#__emptyadmin_emptyitem AS i');

		return $query;
	}
}

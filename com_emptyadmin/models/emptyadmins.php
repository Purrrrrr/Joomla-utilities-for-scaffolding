<?php
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

class EmptyadminModelEmptyadmins extends JModelList
{

	protected function getListQuery()
	{
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
		$query->select('*');
		$query->from('#__emptyadmin AS i');

		return $query;
	}
}

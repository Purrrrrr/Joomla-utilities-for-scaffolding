<?php
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

class EmptyadminViewEmptyitems extends JView
{
	protected $items;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->items = $this->get('Items');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		parent::display($tpl);
		$this->addToolbar();
	}
	protected function addToolbar()
	{
		JToolBarHelper::title('', 'module.png');

    JToolBarHelper::addNew('emptyitem.add');
    //JToolBarHelper::publish('emptyitems.publish', 'JTOOLBAR_PUBLISH', true);
    //JToolBarHelper::unpublish('emptyitems.unpublish', 'JTOOLBAR_UNPUBLISH', true);

    JToolBarHelper::deleteList('Are you ser you want to remove these emptyitems?', 'emptyitems.delete');
	}
}

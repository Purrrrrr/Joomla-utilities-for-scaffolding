<?php
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

class EmptyadminViewEmptyadmins extends JView
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

    JToolBarHelper::addNew('item.add');
    //JToolBarHelper::publish('emptyadmins.publish', 'JTOOLBAR_PUBLISH', true);
    //JToolBarHelper::unpublish('emptyadmins.unpublish', 'JTOOLBAR_UNPUBLISH', true);

    JToolBarHelper::deleteList('Are you ser you want to remove these emptyadmins?', 'emptyadmins.delete');
	}
}

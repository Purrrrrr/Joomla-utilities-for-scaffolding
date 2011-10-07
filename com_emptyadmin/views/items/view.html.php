<?php
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

class EmptyadminViewItems extends JView
{
	protected $f_levels;
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->items		= $this->get('Items');

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
    //JToolBarHelper::publish('items.publish', 'JTOOLBAR_PUBLISH', true);
    //JToolBarHelper::unpublish('items.unpublish', 'JTOOLBAR_UNPUBLISH', true);

    JToolBarHelper::trash('items.trash');
	}
}

<?php
/**
 * @version		$Id: view.html.php 21655 2011-06-23 05:43:24Z chdemko $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.view');

class EmptyadminViewEmptyitem extends JView
{
	protected $form;
	protected $item;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->form		= $this->get('Form');
		$this->item   = $this->get('Item');

		parent::display($tpl);
		$this->addToolbar();
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		JRequest::setVar('hidemainmenu', true);

		$isNew		= ($this->item->id == 0);
		JToolBarHelper::title('');

    JToolBarHelper::apply('emptyitem.apply');
    JToolBarHelper::save('emptyitem.save');
    JToolBarHelper::save2copy('emptyitem.save2copy');

		if ($isNew)  {
			JToolBarHelper::cancel('emptyitem.cancel');
		} else {
			JToolBarHelper::cancel('emptyitem.cancel', 'JTOOLBAR_CLOSE');
		}
	}
}

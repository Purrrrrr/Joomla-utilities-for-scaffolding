<?php
// No direct access
defined('_JEXEC') or die;

// Include dependancies.
jimport('joomla.application.component.modeladmin');

class MenusModelItem extends JModelAdmin
{
	protected function canDelete($record)
  {
    return true;
	}

	/**
	 * Method to test whether a record can have its state edited.
	 *
	 * @param	object	A record object.
	 *
	 * @return	boolean	True if allowed to change the state of the record. Defaults to the permission set in the component.
	 * @since	1.6
	 */
	protected function canEditState($record)
	{
    return parent::canEditState($record);
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

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		return array_merge((array)$this->getItem(), (array)JFactory::getApplication()->getUserState('com_emptyadmin.edit.item.data', array()));
	}

	/**
	 * Get the necessary data to load an item help screen.
	 *
	 * @return	object	An object with key, url, and local properties for loading the item help screen.
	 * @since	1.6
	 */
	public function getHelp()
	{
		return (object) array('key' => $this->helpKey, 'url' => $this->helpURL, 'local' => $this->helpLocal);
	}

	/**
	 * Method to get a menu item.
	 *
	 * @param	integer	$pk	An optional id of the object to get, otherwise the id from the model state is used.
	 *
	 * @return	mixed	Menu item data object on success, false on failure.
	 * @since	1.6
	 */
	public function getItem($pk = null)
	{
		// Initialise variables.
		$pk = (!empty($pk)) ? $pk : (int)$this->getState('item.id');

		// Get a level row instance.
		$table = $this->getTable();

		// Attempt to load the row.
		$table->load($pk);

		// Check for a table object error.
		if ($error = $table->getError()) {
			$this->setError($error);
			$false = false;
			return $false;
		}

		// Prime required properties.

		if ($type = $this->getState('item.type')) {
			$table->type = $type;
		}

		if (empty($table->id)) {
			$table->parent_id	= $this->getState('item.parent_id');
			$table->menutype	= $this->getState('item.menutype');
			$table->params		= '{}';
		}

		// If the link has been set in the state, possibly changing link type.
		if ($link = $this->getState('item.link')) {
			// Check if we are changing away from the actual link type.
			if (MenusHelper::getLinkKey($table->link) != MenusHelper::getLinkKey($link)) {
				$table->link = $link;
			}
		}

		switch ($table->type)
		{
			case 'alias':
				$table->component_id = 0;
				$args = array();

				parse_str(parse_url($table->link, PHP_URL_QUERY), $args);
				break;

			case 'separator':
				$table->link = '';
				$table->component_id = 0;
				break;

			case 'url':
				$table->component_id = 0;

				parse_str(parse_url($table->link, PHP_URL_QUERY));
				break;

			case 'component':
			default:
				// Enforce a valid type.
				$table->type = 'component';

				// Ensure the integrity of the component_id field is maintained, particularly when changing the menu item type.
				$args = array();
				parse_str(parse_url($table->link, PHP_URL_QUERY), $args);

				if (isset($args['option'])) {
					// Load the language file for the component.
					$lang = JFactory::getLanguage();
					$lang->load($args['option'], JPATH_ADMINISTRATOR, null, false, false)
					||	$lang->load($args['option'], JPATH_ADMINISTRATOR.'/components/'.$args['option'], null, false, false)
					||	$lang->load($args['option'], JPATH_ADMINISTRATOR, $lang->getDefault(), false, false)
					||	$lang->load($args['option'], JPATH_ADMINISTRATOR.'/components/'.$args['option'], $lang->getDefault(), false, false);

					// Determine the component id.
					$component = JComponentHelper::getComponent($args['option']);
					if (isset($component->id)) {
						$table->component_id = $component->id;
					}
				}
				break;
		}

		// We have a valid type, inject it into the state for forms to use.
		$this->setState('item.type', $table->type);

		// Convert to the JObject before adding the params.
		$properties = $table->getProperties(1);
		$result = JArrayHelper::toObject($properties, 'JObject');

		// Convert the params field to an array.
		$registry = new JRegistry;
		$registry->loadString($table->params);
		$result->params = $registry->toArray();

		// Merge the request arguments in to the params for a component.
		if ($table->type == 'component') {
			// Note that all request arguments become reserved parameter names.
			$result->request = $args;
			$result->params = array_merge($result->params, $args);
		}

		if ($table->type == 'alias') {
			// Note that all request arguments become reserved parameter names.
			$args = array();
			parse_str(parse_url($table->link, PHP_URL_QUERY), $args);
			$result->params = array_merge($result->params, $args);
		}

		if ($table->type == 'url') {
			// Note that all request arguments become reserved parameter names.
			$args = array();
			parse_str(parse_url($table->link, PHP_URL_QUERY), $args);
			$result->params = array_merge($result->params, $args);
		}

		// Load associated menu items
		if (JFactory::getApplication()->get('menu_associations', 0)) {
			if ($pk != null) {
				$result->associations = MenusHelper::getAssociations($pk);
			}
			else {
				$result->associations = array();
			}
		}

		return $result;
	}

	/**
	 * Get the list of modules not in trash.
	 *
	 * @return	mixed	An array of module records (id, title, position), or false on error.
	 * @since	1.6
	 */
	public function getModules()
	{
		$db = $this->getDbo();
		$query = $db->getQuery(true);

		$query->select('a.id, a.title, a.position, a.published');
		$query->from('#__modules AS a');

		// Join on the module-to-menu mapping table.
		// We are only interested if the module is displayed on ALL or THIS menu item (or the inverse ID number).
		$query->select('map.menuid');
		$query->select('map2.menuid < 0 as except');
		$query->join('LEFT', '#__modules_menu AS map ON map.moduleid = a.id AND (map.menuid = 0 OR ABS(map.menuid) = '.(int) $this->getState('item.id').')');
		$query->join('LEFT', '#__modules_menu AS map2 ON map2.moduleid = a.id AND map2.menuid < 0');
		$query->group('a.id');

		// Join on the asset groups table.
		$query->select('ag.title AS access_title');
		$query->join('LEFT', '#__viewlevels AS ag ON ag.id = a.access');
		$query->where('a.published >= 0');
		$query->where('a.client_id = 0');
		$query->order('a.position, a.ordering');

		$db->setQuery($query);
		$result = $db->loadObjectList();

		if ($error = $db->getError()) {
			$this->setError($error);
			return false;
		}

		return $result;
	}

	/**
	 * A protected method to get the where clause for the reorder
	 * This ensures that the row will be moved relative to a row with the same menutype
	 *
	 * @param	JTableMenu $table instance
	 *
	 * @return	array	An array of conditions to add to add to ordering queries.
	 * @since	1.6
	 */
	protected function getReorderConditions($table)
	{
		return 'menutype = ' . $this->_db->Quote($table->menutype);
	}

	/**
	 * Returns a Table object, always creating it
	 *
	 * @param	type	$type	The table type to instantiate
	 * @param	string	$prefix	A prefix for the table class name. Optional.
	 * @param	array	$config	Configuration array for model. Optional.
	 *
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'Menu', $prefix = 'JTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @return	void
	 * @since	1.6
	 */
	protected function populateState()
	{
		$app = JFactory::getApplication('administrator');

		// Load the User state.
		$pk = (int) JRequest::getInt('id');
		$this->setState('item.id', $pk);

		if (!($parentId = $app->getUserState('com_emptyadmin.edit.item.parent_id'))) {
			$parentId = JRequest::getInt('parent_id');
		}
		$this->setState('item.parent_id', $parentId);

		if (!($menuType = $app->getUserState('com_emptyadmin.edit.item.menutype'))) {
			$menuType = JRequest::getCmd('menutype', 'mainmenu');
		}
		$this->setState('item.menutype', $menuType);

		if (!($type = $app->getUserState('com_emptyadmin.edit.item.type'))){
			$type = JRequest::getCmd('type');
			// Note a new menu item will have no field type.
			// The field is required so the user has to change it.
		}
		$this->setState('item.type', $type);

		if ($link = $app->getUserState('com_emptyadmin.edit.item.link')) {
			$this->setState('item.link', $link);
		}

		// Load the parameters.
		$params	= JComponentHelper::getParams('com_emptyadmin');
		$this->setState('params', $params);
	}

	/**
	 * @param	object	$form	A form object.
	 * @param	mixed	$data	The data expected for the form.
	 *
	 * @return	void
	 * @since	1.6
	 * @throws	Exception if there is an error in the form event.
	 */
	protected function preprocessForm(JForm $form, $data, $group = 'content')
	{
		// Trigger the default form events.
		parent::preprocessForm($form, $data);
	}

	public function save($data)
	{
		// Initialise variables.
		$pk		= (!empty($data['id'])) ? $data['id'] : (int)$this->getState('item.id');
		$isNew	= true;
		$db		= $this->getDbo();
		$table	= $this->getTable();

		// Load the row if saving an existing item.
		if ($pk > 0) {
			$table->load($pk);
			$isNew = false;
		}

		// Set the new parent id if parent id not matched OR while New/Save as Copy .
		if ($table->parent_id != $data['parent_id'] || $data['id'] == 0) {
			$table->setLocation($data['parent_id'], 'last-child');
		}

		// Bind the data.
		if (!$table->bind($data)) {
			$this->setError($table->getError());
			return false;
		}

		// Check the data.
		if (!$table->check()) {
			$this->setError($table->getError());
			return false;
		}

		// Store the data.
		if (!$table->store()) {
			$this->setError($table->getError());
			return false;
		}

		$this->setState('item.id', $table->id);
		return true;
	}


	function publish(&$pks, $value = 1)
	{
		return parent::publish($pks,$value);
	}

}

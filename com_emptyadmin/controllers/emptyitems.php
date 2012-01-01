<?php
defined('_JEXEC') or die;

jimport( 'joomla.application.component.controlleradmin' );

class EmptyadminControllerEmptyitems extends JControllerAdmin
{
  public function getModel($name = 'Emptyitem', $prefix = 'EmptyadminModel') {
    return parent::getModel($name,$prefix);
  }

}

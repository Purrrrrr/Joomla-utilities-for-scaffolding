<?php
defined('_JEXEC') or die;

jimport( 'joomla.application.component.controlleradmin' );

class EmptyadminControllerEmptyadmins extends JControllerAdmin
{
  public function getModel($name = 'Emptyadmin', $prefix = 'EmptyadminModel') {
    return parent::getModel($name,$prefix);
  }

}

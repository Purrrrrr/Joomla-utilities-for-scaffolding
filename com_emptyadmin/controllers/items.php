<?php
defined('_JEXEC') or die;

jimport( 'joomla.application.component.controlleradmin' );

class EmptyadminControllerItems extends JControllerAdmin
{
  public function getModel($name = 'Item', $prefix = 'EmptyadminModel') {
    return parent::getModel($name,$prefix);
  }

}

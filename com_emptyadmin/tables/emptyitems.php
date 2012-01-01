<?php
class EmptyadminTableEmptyitems extends JTable {
  function __construct($db) {
    parent::__construct("#__emptyadmin_emptyitem", "id", $db);
  }
}


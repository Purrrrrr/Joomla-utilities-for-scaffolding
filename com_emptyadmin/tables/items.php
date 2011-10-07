<?php
class EmptyadminTableItems extends JTable {
  function __construct($db) {
    parent::__construct("#__emptyadmin_item", "id", $db);
  }
}


<?php
class EmptyadminTableEmptyadmins extends JTable {
  function __construct($db) {
    parent::__construct("#__emptyadmin", "id", $db);
  }
}


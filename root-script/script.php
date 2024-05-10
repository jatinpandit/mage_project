<?php

require_once('../app/Mage.php');

Mage::app();

// Mage::getModel('vendorinventory/observer')->readCsv();
Mage::getModel('vendorinventory/observer')->instockCheck();
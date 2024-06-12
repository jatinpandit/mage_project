<?php

require_once('../app/Mage.php');

Mage::app();

Mage::getModel('filetransfer/observer')->fetch();
// Mage::getModel('vendorinventory/observer')->instockCheck();

// require 'app/Mage.php';
// Mage::app();

// try {
//     $model = Mage::getModel('productseller/productseller');
//     $collection = $model->getCollection();
//     echo "Collection instantiated successfully!";
// } catch (Exception $e) {
//     echo "Exception: " . $e->getMessage();
// }

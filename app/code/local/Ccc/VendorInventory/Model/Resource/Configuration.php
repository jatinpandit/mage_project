<?php

class Ccc_VendorInventory_Model_Resource_Configuration extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        // echo 123;
        $this->_init('vendorinventory/configuration', 'id');
    }
}
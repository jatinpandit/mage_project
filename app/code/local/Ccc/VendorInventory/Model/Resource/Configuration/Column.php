<?php

class Ccc_VendorInventory_Model_Resource_Configuration_COlumn extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        // echo 123;
        $this->_init('vendorinventory/configuration_column', 'id');
    }
}
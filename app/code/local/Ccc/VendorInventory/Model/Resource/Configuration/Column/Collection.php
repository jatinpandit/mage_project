<?php

class Ccc_VendorInventory_Model_Resource_Configuration_Column_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct()
    {
        $this->_init('vendorinventory/configuration_Column');
        parent::_construct();
    }
}
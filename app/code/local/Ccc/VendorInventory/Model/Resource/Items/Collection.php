<?php

class Ccc_Vendorinventory_Model_Resource_Items_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct()
    {
        $this->_init('vendotinventory/items');
        parent::_construct();
    }
}
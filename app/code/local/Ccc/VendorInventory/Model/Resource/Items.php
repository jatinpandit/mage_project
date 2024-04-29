<?php

class Ccc_Vendorinventory_Model_Resource_Items extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        $this->_init('vendorinventory/items', 'items_id');
    }
}
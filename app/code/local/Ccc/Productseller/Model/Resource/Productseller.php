<?php
class Ccc_Productseller_Model_Resource_Productseller extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        // echo 2;
        $this->_init('ccc_productseller/productseller', 'id');
    }
}

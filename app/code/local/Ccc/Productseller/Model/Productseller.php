<?php
class Ccc_Productseller_Model_Productseller extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        // echo 1;
        $this->_init('ccc_productseller/productseller');
    }



    protected function _beforeSave()
    {
        if ($this->isObjectNew()) {
            $this->setData('created_at', date('d-m-Y'));
        }
        $this->setData('updated_date', date('d-m-Y'));
        return $this;
    }
}

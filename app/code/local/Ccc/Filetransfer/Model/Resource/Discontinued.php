<?php

class Ccc_Filetransfer_Model_Resource_Discontinued extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('filetransfer/discontinued','disc_id');
    }
}
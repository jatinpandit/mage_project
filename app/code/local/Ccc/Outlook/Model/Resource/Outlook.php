<?php

class Ccc_Outlook_Model_Resource_Outlook extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        $this->_init('outlook/outlook', 'id');
    }
}
<?php

class Ccc_Ticket_Model_Ticket extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('ticket/ticket');
    }

    protected function _beforeSave()
    {
        parent::_beforeSave();
        $this->setUpdatedAt(date('d-m-Y'));
        return $this;
    }
}

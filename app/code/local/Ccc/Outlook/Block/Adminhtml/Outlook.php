<?php

class Ccc_Outlook_Block_Adminhtml_Outlook extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup='outlook';
        $this->_controller = 'adminhtml_outlook';
        $this->_headerText = Mage::helper('outlook')->__(' Manage Email');
        $this->_addButtonLabel = Mage::helper('outlook')->__('Add New Email');
        parent::__construct();
    }
}
<?php

class Ccc_Ticket_Block_Adminhtml_View extends Mage_Adminhtml_Block_Widget_Container 
{
    public function __construct()
    {
        // echo 111;
        $this->_blockGroup = "view";
        $this->_controller = "adminhtml_ticket";
        $this->_headerText = "ticket";
        parent::__construct();
        // $this->removeButton('add');
        $this->setTemplate('ticket/view.phtml');
    }
}
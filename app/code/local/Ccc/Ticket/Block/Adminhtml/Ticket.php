<?php

class Ccc_Ticket_Block_Adminhtml_Ticket extends Mage_Adminhtml_Block_Widget_Container 
{
    public function __construct()
    {
        // echo 111;
        $this->_blockGroup = "ticket";
        $this->_controller = "adminhtml_ticket";
        $this->_headerText = "ticket";
        parent::__construct();
        // $this->removeButton('add');
        $this->setTemplate('ticket/grid.phtml');
    }

    public function getTicket()
    { 
        $ticketCollection = Mage::getModel('ticket/ticket')->getCollection();
        return $ticketCollection;
    }

}
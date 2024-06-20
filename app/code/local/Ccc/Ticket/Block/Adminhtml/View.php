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

    public function getTicket()
    {
        $id = $this->getRequest()->getParam('ticket_id');
        $ticket = Mage::getModel('ticket/ticket')->load($id);
        return $ticket;
    }

    public function getUsers()
    {
        $collection = Mage::getModel('admin/user');
        return $collection;
    }

    public function getStatus()
    {
        $collection = Mage::getModel('ticket/status')->getCollection();
        return $collection;
    }

    public function getComment($id)
    {
        return Mage::getModel('ticket/comment')->getCollection()->addFieldToFilter('ticket_id', $id);
    }
}
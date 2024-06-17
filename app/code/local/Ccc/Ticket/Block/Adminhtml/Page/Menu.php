<?php

class Ccc_Ticket_Block_Adminhtml_Page_Menu extends Mage_Adminhtml_Block_Page_Menu
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('ticket/page/menu.phtml');
    }

    public function getUser()
    {
        $user = Mage::getSingleton('admin/session')->getUser();
        return $user->getId();
    }

    public function getAllUsers()
    {
        $collection = Mage::getModel('admin/user')->getCollection();
        return $collection;
    }

    public function getStatus()
    {
        $collection = Mage::getModel('ticket/status')->getCollection();
        // print_r($collection->getData());
        return $collection;
    }
}
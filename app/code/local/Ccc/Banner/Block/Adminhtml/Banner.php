<?php
class Ccc_Banner_Block_Adminhtml_Banner 
extends 
// Ccc_VendorInventory_Block_Adminhtml_Configuration
// Xyz_Practice_Block_Adminhtml_Practice
Mage_Adminhtml_Block_Widget_Grid_Container  
{

    public function __construct()
    {
        // echo 111;
        $this->_blockGroup = 'banner';
        $this->_controller = 'adminhtml_banner';
        $this->_headerText = Mage::helper('banner')->__('Manage Banner');
        $this->_addButtonLabel = Mage::helper('banner')->__('Add New Banner');
        // $this->removeButton()
        parent::__construct();
        $this->setTemplate('banner/grid/container.phtml');
    }

    public function _prepareLayout()
    {
        if(!Mage::getSingleton('admin/session')->isAllowed('banner/page/actions/addButton'))
        {
            $this->removeButton('add');
        }
        return parent::_prepareLayout();
    }

}
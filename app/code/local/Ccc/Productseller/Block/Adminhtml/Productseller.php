<?php

class Ccc_Productseller_Block_Adminhtml_Productseller extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        // echo 111;
        $this->_blockGroup = 'productseller';
        $this->_controller = 'adminhtml_productseller';
        $this->_headerText = "Product Seller";
        $this->_addButtonLabel = 'Add New Seller';
        parent::__construct();
    }

    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    
}
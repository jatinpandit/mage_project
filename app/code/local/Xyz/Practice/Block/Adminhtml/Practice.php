<?php

class Xyz_Practice_Block_Adminhtml_Practice extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        echo "Practice Block";
        $this->_blockGroup = 'vendorinventory';
        $this->_controller = 'adminhtml_configuration';
        $this->_headerText = Mage::helper('vendorinventory')->__('Configuration');
        // $this->_addButtonLabel = Mage::helper('vendorinventory')->__('Add New Configuration');
        // parent::__construct();
        // $this->removeButton('add');
        // $this->removeButton()
        // $this->setTemplate('configuration/grid/container.phtml');
    }
}
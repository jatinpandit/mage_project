<?php
class Ccc_VendorInventory_Block_Adminhtml_Configuration extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        // echo "Confoguration Block";
        $this->_blockGroup = 'vendorinventory';
        $this->_controller = 'adminhtml_configuration';
        $this->_headerText = Mage::helper('vendorinventory')->__('Configuration');
        // $this->_addButtonLabel = Mage::helper('vendorinventory')->__('Add New Configuration');
        parent::__construct();
        $this->removeButton('add');
        // $this->removeButton()
        // $this->setTemplate('configuration/grid/container.phtml');
    }

}
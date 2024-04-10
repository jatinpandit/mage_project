<?php
class Ccc_Banner_Block_Adminhtml_Banner extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_blockGroup = 'banner';
        $this->_controller = 'adminhtml_banner';
        $this->_headerText = Mage::helper('banner')->__('Manage Banner');
        $this->_addButtonLabel = Mage::helper('banner')->__('Add New Banner');
        // $this->removeButton()
        parent::__construct();
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
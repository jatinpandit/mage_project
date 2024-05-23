<?php

class Ccc_Productseller_Block_Adminhtml_Productseller_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        // echo 11;die;
        parent::__construct();  
        $this->_blockGroup = 'productseller';
        $this->_objectId = 'id';
        $this->_controller = 'adminhtml_productseller';
        // $this->setTitle(Mage::helper('productseller')->__('Edit Seller'));
        $this->_updateButton('save', 'label', Mage::helper('productseller')->__('Save Seller'));
        $this->_updateButton('delete', 'label', Mage::helper('productseller')->__('Delete Seller'));
        
        // echo 111;die;

        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save and Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if (Mage::registry('ccc_productseller')->getId()) {
            return Mage::helper('productseller')->__("Edit Seller '%s'", $this->escapeHtml(Mage::registry('ccc_productseller')->getSellerName()));
        }
        else {
            return Mage::helper('productseller')->__('New Seller');
        }
    }
}
<?php

class Ccc_Filetransfer_Block_Adminhtml_Configuration_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'filetransfer';
        $this->_objectId = 'config_id';
        $this->_controller = 'adminhtml_configuration';

        parent::__construct();

        $this->_updateButton('save', 'label', Mage::helper('filetransfer')->__('Save config'));
        $this->_updateButton('delete', 'label', Mage::helper('filetransfer')->__('Delete config'));

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
        if (Mage::registry('ccc_filetransfer')->getConfigId()) {
            return Mage::helper('filetransfer')->__("Edit Config '%s'", $this->escapeHtml(Mage::registry('ccc_filetransfer')->getConfigId()));
        }
        else {
            return Mage::helper('filetransfer')->__('New Config');
        }
    }
    

}

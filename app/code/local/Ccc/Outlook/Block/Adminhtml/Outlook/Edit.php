<?php

class Ccc_Outlook_Block_Adminhtml_Outlook_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'outlook';
        $this->_objectId = 'id';
        $this->_controller = 'adminhtml_outlook';

        parent::__construct();

        $this->_updateButton('save', 'label', Mage::helper('outlook')->__('Save Email'));
        $this->_updateButton('delete', 'label', Mage::helper('outlook')->__('Delete Email'));

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
}
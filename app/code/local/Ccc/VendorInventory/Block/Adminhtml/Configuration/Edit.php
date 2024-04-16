<?php
class Ccc_VendorInventory_Block_Adminhtml_Configuration_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'vendorinventory';
        $this->_objectId = 'configuration_id';
        $this->_controller = 'adminhtml_configuration';
        $this->setTitle(Mage::helper('vendorinventory')->__('Edit Configuration'));

        parent::__construct();

        $this->_updateButton('save', 'label', Mage::helper('vendorinventory')->__('Save Configuration'));
        $this->_updateButton('delete', 'label', Mage::helper('vendorinventory')->__('Delete Configuration'));

        // $this->_addButton('saveandcontinue', array(
        //     'label'     => Mage::helper('adminhtml')->__('Save and Continue Edit'),
        //     'onclick'   => 'saveAndContinueEdit()',
        //     'class'     => 'save',
        // ), -100);

        // $this->_formScripts[] = "
            

        //     function saveAndContinueEdit(){
        //         editForm.submit($('edit_form').action+'back/edit/');
        //     }
        // ";
    }
}
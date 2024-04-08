<?php
class Ccc_Banner_Block_Adminhtml_Banner_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'banner';
        $this->_objectId = 'banner_id';
        $this->_controller = 'adminhtml_banner';
        $this->setTitle(Mage::helper('banner')->__('Edit Banner'));

        parent::__construct();

        $this->_updateButton('save', 'label', Mage::helper('banner')->__('Save Banner'));
        $this->_updateButton('delete', 'label', Mage::helper('banner')->__('Delete Banner'));

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

    /**
     * Get edit form container header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        if (Mage::registry('ccc_banner')->getId()) {
            return Mage::helper('banner')->__("Edit Banner '%s'", $this->escapeHtml(Mage::registry('ccc_banner')->getTitle()));
        }
        else {
            return Mage::helper('banner')->__('New Banner');
        }
    }

}

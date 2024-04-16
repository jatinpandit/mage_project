<?php

class Ccc_VendorInventory_Block_Adminhtml_Configuration_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('configuration_form');
        $this->setTitle(Mage::helper('vendorinventory')->__('Configuration'));
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);

    }

    protected function _prepareForm()
    {
        $model = Mage::registry('ccc_vendorinventory');

        $form = new Varien_Data_Form(
            array('id' => 'edit_form', 'action' => $this->getUrl('*/*/save'), 'method' => 'post', 'enctype' => 'multipart/form-data')
        );

        $form->setHtmlIdPrefix('configuration_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('vendorinventory')->__('Configuration Information'), 'class' => 'fieldset-wide'));

        if ($model->getBannerId()) {
            $fieldset->addField('configuration_id', 'hidden', array(
                'name' => 'configuration_id',
            )
            );
        }

        $fieldset->addField('configuration_name', 'text', array(
            'name' => 'configuration_name',
            'label' => Mage::helper('banner')->__('Configuration Name'),
            'title' => Mage::helper('banner')->__('Configuration Name'),
            'required' => true,
        )
        );

        $fieldset->addField('file_format', 'text', array(
            'name' => 'file_format',
            'label' => Mage::helper('banner')->__('File Format'),
            'title' => Mage::helper('banner')->__('File Format'),
            'required' => true,
            // 'class'     => 'validate-xml-identifier',
        )
        );

        $fieldset->addField('file_name', 'text', array(
            'name' => 'file_name',
            'label' => Mage::helper('banner')->__('File Name'),
            'title' => Mage::helper('banner')->__('File Name'),
            'required' => true,
        )
        );

        if (!$model->getId()) {
            $model->setData('status', '1');
        }

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
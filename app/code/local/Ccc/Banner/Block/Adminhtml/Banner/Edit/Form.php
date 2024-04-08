<?php

class Ccc_Banner_Block_Adminhtml_Banner_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('banner_form');
        $this->setTitle(Mage::helper('banner')->__('Banner'));
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);

    }

    protected function _prepareForm()
    {
        $model = Mage::registry('ccc_banner');

        $form = new Varien_Data_Form(
            array('id' => 'edit_form', 'action' => $this->getUrl('*/*/save'), 'method' => 'post', 'enctype' => 'multipart/form-data')
        );

        $form->setHtmlIdPrefix('banner_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('banner')->__('Banner Information'), 'class' => 'fieldset-wide'));

        if ($model->getBannerId()) {
            $fieldset->addField('banner_id', 'hidden', array(
                'name' => 'banner_id',
            )
            );
        }

        $fieldset->addField('title', 'text', array(
            'name' => 'title',
            'label' => Mage::helper('banner')->__('Banner Title'),
            'title' => Mage::helper('banner')->__('Banner Title'),
            'required' => true,
        )
        );

        $fieldset->addField('banner_image', 'image', array(
            'name' => 'banner_image',
            'label' => Mage::helper('banner')->__('Banner Image'),
            'title' => Mage::helper('banner')->__('Banner Image'),
            'required' => true,
            // 'class'     => 'validate-xml-identifier',
        )
        );

        $fieldset->addField('show_on', 'text', array(
            'name' => 'show_on',
            'label' => Mage::helper('banner')->__('Show On'),
            'title' => Mage::helper('banner')->__('Show On'),
            'required' => true,
        )
        );

        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('banner')->__('Banner Status'),
            'title' => Mage::helper('banner')->__('Banner Status'),
            'name' => 'status',
            'required' => true,
            'options' => array(
                '1' => Mage::helper('banner')->__('Enabled'),
                '0' => Mage::helper('banner')->__('Disabled'),
            ),
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
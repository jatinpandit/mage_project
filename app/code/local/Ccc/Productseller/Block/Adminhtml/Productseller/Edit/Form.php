<?php
class Ccc_Productseller_Block_Adminhtml_Productseller_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    public function __construct()
    {
        parent::__construct();
        // echo 111;
        $this->setId('seller_form');
        $this->setTitle(Mage::helper('productseller')->__('Seller Information'));
        $this->_prepareForm();
    }   

    protected function _prepareForm()
    {
        // echo 11333331;
        // die;
        $model = Mage::registry('ccc_productseller');

        $form = new Varien_Data_Form(
            array('id' => 'edit_form', 'action' => $this->getUrl('*/*/save'), 'method' => 'post')
        );
        $form->setHtmlIdPrefix('seller_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('productseller')->__('Seller Information'), 'class' => 'fieldset-wide'));

        if ($model->getId()) {
            $fieldset->addField(
                'id',
                'hidden',
                array(
                    'name' => 'id',
                )
            );
        }

        $fieldset->addField(
            'seller_name',
            'text',
            array(
                'name' => 'seller_name',
                'label' => Mage::helper('productseller')->__('Seller Name'),
                'title' => Mage::helper('productseller')->__('Seller Name'),
                'required' => true,
            )
        );

        $fieldset->addField(
            'company_name',
            'text',
            array(
                'name' => 'company_name',
                'label' => Mage::helper('productseller')->__('Company Name'),
                'title' => Mage::helper('productseller')->__('Company Name'),
                'required' => true,
            )
        );

        $fieldset->addField(
            'address',
            'text',
            array(
                'name' => 'address',
                'label' => Mage::helper('productseller')->__('Address'),
                'title' => Mage::helper('productseller')->__('Address'),
                'required' => true,
            )
        );

        $fieldset->addField(
            'city',
            'text',
            array(
                'name' => 'city',
                'label' => Mage::helper('productseller')->__('City'),
                'title' => Mage::helper('productseller')->__('City'),
                'required' => true,
            )
        );

        $fieldset->addField(
            'state',
            'text',
            array(
                'name' => 'state',
                'label' => Mage::helper('productseller')->__('State'),
                'title' => Mage::helper('productseller')->__('State'),
                'required' => true,
            )
        );

        $fieldset->addField(
            'country',
            'text',
            array(
                'name' => 'country',
                'label' => Mage::helper('productseller')->__('Country'),
                'title' => Mage::helper('productseller')->__('Country'),
                'required' => true,
            )
        );
        $fieldset->addField(
            'is_active',
            'select',
            array(
                'label' => Mage::helper('productseller')->__('Is Active'),
                'title' => Mage::helper('productseller')->__('Is Active'),
                'name' => 'is_active',
                'required' => true,
                'options' => array(
                    '1' => Mage::helper('productseller')->__('Yes'),
                    '0' => Mage::helper('productseller')->__('No'),
                ),
            )
        );
        if (!$model->getId()) {
            $model->setData('is_active', '1');
        }
        
        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

}

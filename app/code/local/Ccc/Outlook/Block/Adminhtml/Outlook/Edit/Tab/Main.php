<?php
class Ccc_Outlook_Block_Adminhtml_Outlook_Edit_Tab_Main extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    protected function _prepareForm()
    {
        $model = Mage::registry('ccc_outlook');

        $form = new Varien_Data_Form(
            array('id' => 'edit_form', 'action' => $this->getUrl('*/*/save'), 'method' => 'post')
        );
        $form->setHtmlIdPrefix('outlook_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('outlook')->__('Configuration Information'), 'class' => 'fieldset-wide'));

        if ($model->getId()) {
            $fieldset->addField(
                'id',
                'hidden',
                array(
                    'name' => 'id',
                )
            );
        }

        $fieldset->addField('username', 'text', array(
            'name' => 'username',
            'label' => Mage::helper('outlook')->__('Username'),
            'title' => Mage::helper('outlook')->__('Username'),
            'required' => true,
            
        )
        );


        $fieldset->addField(
            'password',
            'text',
            array(
                'name' => 'password',
                'label' => Mage::helper('outlook')->__('Password'),
                'title' => Mage::helper('outlook')->__('Password'),
                'required' => true,
            )
        );

        $fieldset->addField(
            'api_url',
            'text',
            array(
                'name' => 'api_url',
                'label' => Mage::helper('outlook')->__('API URL'),
                'title' => Mage::helper('outlook')->__('API URL'),
                'required' => true,
            )
        );

        $fieldset->addField(
            'api_key',
            'text',
            array(
                'name' => 'api_key',
                'label' => Mage::helper('outlook')->__('API Key'),
                'title' => Mage::helper('outlook')->__('API Key'),
                'required' => true,
            )
        );
        $fieldset->addField(
            'is_active',
            'select',
            array(
                'label' => Mage::helper('outlook')->__('Is Active'),
                'title' => Mage::helper('outlook')->__('Is Active'),
                'name' => 'is_active',
                'required' => true,
                'options' => array(
                    '1' => Mage::helper('outlook')->__('Enabled'),
                    '0' => Mage::helper('outlook')->__('Disabled'),
                ),
            )
        );
        if (!$model->getId()) {
            $model->setData('is_active', '1');
        }


        $form->setValues($model->getData());
        // $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
   
    public function getTabLabel()
    {
        return Mage::helper('outlook')->__('Configuration Information');
    }
    public function getTabTitle()
    {
        return Mage::helper('outlook')->__('Configuration Information');
    }
    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }

}
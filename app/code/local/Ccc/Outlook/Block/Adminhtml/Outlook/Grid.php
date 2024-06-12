<?php

class Ccc_Outlook_Block_Adminhtml_Outlook_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        // echo 111;
        parent::__construct();
        $this->setId('emailGrid');
        // $this->setDefaultSort('id');
        // $this->setDefaultDir('ASC');
    }

    protected function _prepareCollection()
    {

        $collection = Mage::getModel('outlook/outlook')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();


        $this->addColumn(
            'username',
            array(
                'header' => Mage::helper('outlook')->__('User Name'),
                'align' => 'left',
                'index' => 'username',
            )
        );

        $this->addColumn(
            'password',
            array(
                'header' => Mage::helper('outlook')->__('Password'),
                'align' => 'left',
                'index' => 'password'
            )
        );
        $this->addColumn(
            'api_url',
            array(
                'header' => Mage::helper('outlook')->__('Api Url'),
                'align' => 'left',
                'index' => 'api_url'
            )
        );

        $this->addColumn(
            'api_key',
            array(
                'header' => Mage::helper('outlook')->__('Api Key'),
                'align' => 'left',
                'index' => 'api_key'
            )
        );


        $this->addColumn(
            'is_active',
            array(
                'header' => Mage::helper('outlook')->__('Is Active'),
                'index' => 'is_active',
                'type' => 'options',
                'options' => array(
                    0 => 'No',
                    1 => 'Yes'
                ),
            )
        );

        return parent::_prepareColumns();
    }
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}
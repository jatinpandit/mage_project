<?php

class Ccc_Productseller_Block_Adminhtml_Productseller_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        // echo 111;
        parent::__construct();
        $this->setId('productsellerGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('Asc');

    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('ccc_productseller/productseller')->getCollection();
        // var_dump(get_class(Mage::getModel('productseller/productseller')->getResource()));
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('seller_name', array(
            'header' => 'Seller Name',
            'align' => 'left',
            'index' => 'seller_name'
        ));

        $this->addColumn('company_name', array(
            'header' => 'Company Name',
            'align' => 'left',
            'index' => 'company_name'
        ));

        $this->addColumn('address', array(
            'header' => 'Address',
            'align' => 'left',
            'index' => 'address'
        ));
        $this->addColumn('city', array(
            'header' => 'City',
            'align' => 'left',
            'index' => 'city'
        ));
        $this->addColumn('state', array(
            'header' => 'State',
            'align' => 'left',
            'index' => 'state'
        ));
        $this->addColumn('country', array(
            'header' => 'Country',
            'align' => 'left',
            'index' => 'country'
        ));
        $this->addColumn('is_active', array(
            'header'    => 'Active',
            'index'     => 'is_active',
            'type'      => 'options',
            'options'   => array(
                0 => 'No',
                1 => 'Yes'
            ),
        ));
        $this->addColumn('created_at', array(
            'header' => 'Created At',
            'align' => 'left',
            'index' => 'created_at'
        ));
        $this->addColumn('updated_date', array(
            'header' => 'Updated Date',
            'align' => 'left',
            'index' => 'updated_date'
        ));

        return parent::_prepareColumns();

    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('seller_ids');
        $this->getMassactionBlock()->setUseSelectAll(false);


        $statuses = [
            0 => "No",
            1 => "Yes",
        ];

        $this->getMassactionBlock()->addItem('is_active', array(
            'label' => Mage::helper('productseller')->__('Change Is Active'),
            'url'  => $this->getUrl('*/*/massUpdateIsActive', array('_current' => true)),
            'additional' => array(
                'visibility' => array(
                    'name' => 'is_active',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('productseller')->__('Active'),
                    'values' => $statuses
                )
            )
        ));

        return $this;
    }
}
<?php

class Ccc_VendorInventory_Block_Adminhtml_Configuration_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('vendorinventoryConfigurationGrid');
        $this->setDefaultSort('configuration_id');
        $this->setDefaultDir('ASC');
        $this->setTemplate('vendorinventory/vendorinventory.phtml');
    }

    // protected function _prepareCollection()
    // {
    //     $collection = Mage::getModel('vendorinventory/configuration')->getCollection();
    //     /* @var $collection Mage_Cms_Model_Mysql4_Block_Collection */
    //     $this->setCollection($collection);
    //     return parent::_prepareCollection();
    // }

    // protected function _prepareColumns()
    // {
    //     $baseUrl = $this->getUrl();

    //     $this->addColumn('configuration_id', array(
    //         'header' => Mage::helper('vendorinventory')->__('ID'),
    //         'align' => 'left',
    //         'index' => 'configuration_id'
    //     )
    //     );

    //     $this->addColumn('configuration_name', array(
    //         'header' => Mage::helper('vendorinventory')->__('Configuration Name'),
    //         'align' => 'left',
    //         'index' => 'configuration_name'
    //     )
    //     );

    //     $this->addColumn('file_format', array(
    //         'header' => Mage::helper('vendorinventory')->__('File Format'),
    //         'align' => 'left',
    //         'index' => 'file_format'
    //     )
    //     );

    //     $this->addColumn('file_name', array(
    //         'header' => Mage::helper('vendorinventory')->__('File Name'),
    //         'align' => 'left',
    //         'index' => 'file_name'
    //     )
    //     );
    //     $this->addColumn('action',
    //         array(
    //             'header'    =>  Mage::helper('vendorinventory')->__('Action'),
    //             'width'     => '100',
    //             'type'      => 'action',
    //             'getter'    => 'getId',
    //             'actions'   => array(
    //                 array(
    //                     'caption'   => Mage::helper('vendorinventory')->__('Process File'),
    //                     'url'       => array('base'=> '*/*/edit'),
    //                     'field'     => 'id'
    //                 )
    //             ),
    //             'filter'    => false,
    //             'sortable'  => false,
    //             'index'     => 'stores',
    //             'is_system' => true,
    //     ));
    //     return parent::_prepareColumns();
    // }

    // public function getRowUrl($row)
    // {
    //     return $this->getUrl('*/*/edit', array('configuration_id' => $row->getId()));
    // }

}
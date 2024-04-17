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

    // protected function getEavModelCollection()
    // {
    //     return Mage::getModel('eav/entity_attribute_option')->getCollection()->addFieldtoFilter('attribute_id', 216)->load();
    // }

    // protected function getBrandNameCollection()
    // {
    //     return Mage::getModel('eav/entity_attribute_option_value')->getCollection();
    // }

    // protected function getBrandName()
    // {
    //     $readConnection = Mage::getSingleton('core/resource')->getConnection('core_read');
    //     $tableNameOptionValue = Mage::getSingleton('core/resource')->getTableName('eav_attribute_option_value');
    //     $tableNameOption = Mage::getSingleton('core/resource')->getTableName('eav_attribute_option');

    //     $select = $readConnection->select()
    //         ->from(array('a' => $tableNameOptionValue), array('value'))
    //         ->join(
    //             array('t' => $tableNameOption),
    //             'a.option_id = t.option_id',
    //             array()
    //         )
    //         ->where('t.attribute_id = ?', 216);

    //     $brandNames = $readConnection->fetchCol($select);
    //     return $brandNames;
    // }

    // protected function getBrandName()
    // {
    //     $adapter = $this->_getReadAdapter();
    //     // $resource = Mage::getSingleton('core/resource');
    //     // $readConnection = $resource->getConnection('core_read');
    //     // $bind    = array(
    //     //     ':entity_type_code' => $entityType,
    //     //     ':attribute_code'   => $code
    //     // );

    //     $select = $adapter->select()
    //     ->from(array('a' => $this->getTable('eav_attribute_option_value')), array('a.value'))
    //     ->join(
    //         array('t' => $this->getTable('eav_attribute_option')),
    //         'a.option_id = t.option_id',
    //         array())
    //     ->where('t.attribute_id = 216 ');
    //     // ->where('a.attribute_code = :attribute_code');

    //     // $result = $readConnection->fetchOne($select);
    //     // return $result;
    //     return $adapter->fetchOne($select);
    // }

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
<?php

class Ccc_Banner_Block_Adminhtml_Banner_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('bannerGrid');
        $this->setDefaultSort('banner_id');
        $this->setDefaultDir('ASC');
    }

    protected function _prepareCollection()
    {
        if(Mage::getSingleton('admin/session')->isAllowed('banner/page/actions/show_all')){
            $collection = Mage::getModel('banner/banner')->getCollection();
            /* @var $collection Mage_Cms_Model_Mysql4_Block_Collection */
            $this->setCollection($collection);
            return parent::_prepareCollection();
        } 
        else{
            $collection = Mage::getModel('banner/banner')->getCollection();
            $collection->setOrder('banner_id', 'desc')->setPageSize(5)->load();
            /* @var $collection Mage_Cms_Model_Mysql4_Block_Collection */
            $this->setCollection($collection);
            return parent::_prepareCollection();
        }  
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        // if(Mage::getSingleton('admin/session')->isAllowed('banner/page/actions/show_title')){
            $this->addColumn('title', array(
                'header'    => Mage::helper('banner')->__('Title'),
                'align'     => 'left',
                'index'     => 'title',
                'isAllowed' => Mage::getSingleton('admin/session')->isAllowed('banner/page/actions/show_title')
            ));
        // }

        $this->addColumn('banner_image', array(
            'header'    => Mage::helper('banner')->__('Banner Image'),
            'align'     => 'left',
            'index'     => 'banner_image'
        ));

        $this->addColumn('show_on', array(
            'header'    => Mage::helper('banner')->__('Show On'),
            'align'     => 'left',
            'index'     => 'show_on'
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('banner')->__('Status'),
            'index'     => 'status',
            'type'      => 'options',
            'options'   => array(
                0 => 'Disabled',
                1 => 'Enabled'
            ),
        ));


        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('banner_id' => $row->getId()));
    }
    
}
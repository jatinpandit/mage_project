<?php
class Ccc_Productseller_Adminhtml_ReportController extends Mage_Adminhtml_Controller_Action
{
    public function _initAction()
    {
        $this->loadLayout();
        return $this;
    }

    public function indexAction()
    {
        // $this->_title($this->__('Seller Report'));
        $this->_initAction();
        $this->renderLayout();
    }

    public function loadProductsAction()
    {
        $sellerId = $this->getRequest()->getPost('seller_id');
        // print_r($sellerId);
        if ($sellerId) {
            $resource = Mage::getSingleton('core/resource');
            $readConnection = $resource->getConnection('core_read');
            $entityId = $readConnection->select()
            ->from(array('catalog' => $resource->getTableName('catalog_product_entity_varchar')), array('catalog.entity_id'))
            ->join(array('value' => $resource->getTableName('ccc_seller')), 'catalog.value = value.id', array())
            // 'catalog.value = value.option_id', array())
            ->where('catalog.attribute_id= ?',218)
            ->where('value.id = ?',$sellerId);
            // echo "<pre>";
            $entity = $readConnection->fetchAll($entityId);
            $model = Mage::getModel('catalog/product');
            $response = [];
            foreach ($entity as $Ids) {
                $response[] = $model->load($Ids['entity_id'])->getData();
            }
            $this->getResponse()->setBody(json_encode($response));
        } else {
            $this->getResponse()->setBody('No seller selected.');
        }
    }
}
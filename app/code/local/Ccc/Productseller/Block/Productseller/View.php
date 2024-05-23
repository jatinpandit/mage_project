<?php

class Ccc_Productseller_Block_Productseller_View extends Mage_Catalog_Block_Product_Abstract
{
    public function getDisplayData()
    {
        $product = $this->getProduct();
        $sellerId = $product->getSellerID();

        if($sellerId != 0){
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        $table = $resource->getTableName('ccc_seller');
        $select = $readConnection->select()->from($table, array('seller_name', 'company_name', 'address'))
            ->where('id = ?', $sellerId);
        $data = $readConnection->fetchAll($select);
        return $data[0];
        }
    }
}


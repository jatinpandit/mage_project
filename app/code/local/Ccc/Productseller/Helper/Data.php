<?php

class Ccc_Productseller_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getSellerOptions()
    {
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');

        $select = $readConnection->select()
            ->from(array('option' => $resource->getTableName('catalog_product_entity_varchar')), array('option.value'))
            ->join(array('value' => $resource->getTableName('ccc_seller')),
            'option.value = value.id', array('value.company_name'))
            // ->join(array('seller'=>$resource->getTableName('ccc_seller')),
            // 'value.value = seller.id',array('seller.company_name'))
            ->where('option.attribute_id = ?', 218)
        ;

        return $readConnection->fetchPairs($select);
    }

}
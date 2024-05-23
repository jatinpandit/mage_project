<?php

class Ccc_Productseller_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getSellerOptions()
    {
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');

        $select = $readConnection->select()
            ->from(array('option' => $resource->getTableName('eav_attribute_option')), array('option.option_id'))
            ->join(array('value' => $resource->getTableName('eav_attribute_option_value')),
            'option.option_id = value.option_id', array())
            ->join(array('seller'=>$resource->getTableName('ccc_seller')),
            'value.value = seller.id',array('seller.company_name'))
            ->where('option.attribute_id = ?', 218)
        ;

        return $readConnection->fetchPairs($select);
    }

}
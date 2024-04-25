<?php

class Ccc_VendorInventory_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getBrandNames()
    {
        // Get the resource model
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        
        // Define table names
        $optionValueTable = $resource->getTableName('eav_attribute_option_value');
        $optionTable = $resource->getTableName('eav_attribute_option');
        
        // Prepare the SQL query
        $select = $readConnection->select()
            ->from(array('a' => $optionTable), array('option_id'))
            ->join(
                array('t' => $optionValueTable),
                'a.option_id = t.option_id',
                array('value')
            )
            ->where('a.attribute_id = ?', 216);
        
        // Execute the query and fetch results
        $brandNames = $readConnection->fetchPairs($select);
        
        return $brandNames;
    }

    public function checkBrand($brandId)
    {
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        
        $tableOne = $resource->getTableName('ccc_vendorinventory_column_configuration');
        $tableTwo = $resource->getTableName('ccc_vendorinventory_brand_configuration');

        $select = $readConnection->select()
            ->from(array('a' => $tableOne), array('a.*'))
            ->join(
                array('t' => $tableTwo),
                'a.brand_table_id = t.id',
                array('t.*')
            )
            ->where('t.brand_id = ?', $brandId);
        
        // Execute the query and fetch results
        $brand = $readConnection->fetchAll($select);
        
        return $brand;
    }
}
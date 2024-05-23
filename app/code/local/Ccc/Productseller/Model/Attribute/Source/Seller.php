<?php

class Ccc_Productseller_Model_Attribute_Source_Seller extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    public function getAllOptions()
    {
        if (!$this->_options) {
            $options = array();
            $data = $this->_getDataFromDatabase();
            foreach ($data as $row) {
                $options[] = array(
                    'label' => $row['seller_name'],
                    'value' => $row['id'],
                );
            }
            $this->_options = $options;
        }
        return $this->_options;
    }

     public function getOptionArray()
    {
        // if (!$this->_options) {
            $options = array();
            $data = $this->_getDataFromDatabase();
            foreach ($data as $row) {
                $options[] = array(
                    // 'label' => $row['seller_name'],
                    $row['id'] => $row['seller_name']
                );
            }
            $this->_options = $options;
        // }
        return $this->_options;
    }

    protected function _getDataFromDatabase()
    {
    
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        $table = $resource->getTableName('ccc_seller'); 
        $select = $readConnection->select()->from($table, array('seller_name', 'id'));
        $data = $readConnection->fetchAll($select);
        return $data;
    }
}

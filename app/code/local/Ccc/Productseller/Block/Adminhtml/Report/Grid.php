<?php

class Ccc_Productseller_Block_Adminhtml_Report_Grid extends 
Mage_Adminhtml_Block_Template
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('productseller/report.phtml');
        // echo 111;
    }

    public function getSeller()
    {
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        $table = $resource->getTableName('ccc_seller');
        
        // Select all seller IDs and names from the table
        $select = $readConnection->select()
            ->from($table, array('id', 'seller_name'));
        
        // Fetch all data
        $data = $readConnection->fetchAll($select);
        
        // Create an associative array with seller IDs as keys and seller names as values
        $sellers = array();
        foreach ($data as $row) {
            $sellers[$row['id']] = $row['seller_name'];
        }
        
        return $sellers;
    }
}
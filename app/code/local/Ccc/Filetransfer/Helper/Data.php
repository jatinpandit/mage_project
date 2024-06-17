<?php
class Ccc_Filetransfer_Helper_Data extends Mage_Core_Helper_Abstract
{
    protected $_rows = [
        "items.item.itemIdentification.itemIdentifier:itemNumber",
        "items.item.itemIdentification.itemCharacteristics.itemDimensions.depth:value",
        "items.item.itemIdentification.itemCharacteristics.itemDimensions.height:value",
        "items.item.itemIdentification.itemCharacteristics.itemDimensions.length:value",
        "items.item.itemIdentification.itemCharacteristics.itemDimensions.weight:value"
    ];
    
    public function getRow()
    {
     $rows = [];
     
     foreach($this->_rows as $_row){
        $parts = explode(':',$_row);
        $rows[] = ['parts' => $parts[0],
                    'attribute' => $parts[1]]; 
     }

     return $rows;
    }
}
	 
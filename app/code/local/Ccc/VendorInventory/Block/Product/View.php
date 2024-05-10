<?php

class Ccc_VendorInventory_Block_Product_View extends Mage_Catalog_Block_Product_Abstract
{
    public function getDate()
    {
        // echo 111;
        $product = $this->getProduct();
        $instockDate = $product->getInstockDate();
        // echo $product->getsku();
        // print_r($instockDate);   
        if ($instockDate) {
            $date = DateTime::createFromFormat('d/m/Y', $instockDate);
            $today = new DateTime();
            $difference = $date->diff($today)->days;

            if ($date <= $today) {
                return $today->modify('+2 days')->format('d-M-Y');
            } elseif ($difference < 25) {
                // echo 111;
                return $today->modify('+7 days')->format('d-M-Y') . ' to ' . $today->modify('+3 days')->format('d-M-Y');
            } else {
                return $today->modify('+15 days')->format('d-M-Y') . ' to ' . $today->modify('+5 days')->format('d-M-Y');
            }

        } else {
            return 'Backorder';
        }
    }
}   
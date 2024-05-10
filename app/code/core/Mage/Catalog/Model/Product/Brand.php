<?php

class Mage_Catalog_Model_Product_Brand extends Varien_Object
{
    const PRADA = 233;
    const GUCCI = 234;
    const BALENCIAGA = 235;
    const LOUIS_VUITTON = 236;

    static public function getOptionArray()
    {
        return array(
            self::PRADA=> Mage::helper('catalog')->__('PRADA'),
            self::GUCCI => Mage::helper('catalog')->__('GUCCI'),
            self::BALENCIAGA  => Mage::helper('catalog')->__('BALENCIAGA'),
            self::LOUIS_VUITTON       => Mage::helper('catalog')->__('LOUIS VUITTON')
        );
    }
}
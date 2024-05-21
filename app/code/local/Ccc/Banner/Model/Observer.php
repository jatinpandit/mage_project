<?php

class Ccc_Banner_Model_Observer
{
    public function bannerUpdated($observer)
    {
        // echo 1;
        $val = Mage::getStoreConfig('banner/general/banner_enabled');
        if ($val == 1) {
            Mage::getConfig()->saveConfig('advanced/modules_disable_output/Ccc_Banner', 0);
        } else {
            Mage::getConfig()->saveConfig('advanced/modules_disable_output/Ccc_Banner', 1);
        }
    }
    public function advancedUpdated($observer)
    {
        $val = Mage::getStoreConfig('advanced/modules_disable_output/Ccc_Banner');
        if ($val == 1) {
            Mage::getConfig()->saveConfig('banner/general/banner_enabled', 0);
        } else {
            Mage::getConfig()->saveConfig('banner/general/banner_enabled', 1);
        }
    }
}
<?php

class Ccc_Test_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        echo 456;
        echo "<pre>";
        $var = Mage::getModel('abc/abc');
        var_dump($var);
    }
}
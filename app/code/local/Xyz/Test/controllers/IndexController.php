<?php

class Xyz_Test_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        echo 123;
        echo "<pre>";
        $var = Mage::getModel('test1/abc');
        var_dump($var);
    }
}
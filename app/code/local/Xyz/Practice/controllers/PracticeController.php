<?php

class Xyz_Practice_PracticeController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
        // echo 111;
    }
}
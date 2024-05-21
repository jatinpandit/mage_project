<?php
require_once("Ccc/Banner/controllers/Adminhtml/BannerController.php");

class Ccc_Test_Adminhtml_BannerController extends Ccc_Banner_Adminhtml_BannerController
{
    public function indexAction()
    {
        // var_dump((int)(1));
        echo "Test Controller";
        // $this->_title($this->__('Banner'))
        //     ->_title($this->__('Banner'))
        //     ->_title($this->__('Manage Banner'));
        // $this->loadLayout();
        $this->_initAction();
        $this->renderLayout();
    }
}
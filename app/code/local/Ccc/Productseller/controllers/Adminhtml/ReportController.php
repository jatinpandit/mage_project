<?php
class Ccc_Productseller_Adminhtml_ReportController extends Mage_Adminhtml_Controller_Action
{
    public function _initAction()
    {
        // echo 111;
        $this->loadLayout();
        return $this;

    }

    public function indexAction()
    {
        // $this->_title($this->__('Seller Report'));
        $this->_initAction();
        $this->renderLayout();
    }
}
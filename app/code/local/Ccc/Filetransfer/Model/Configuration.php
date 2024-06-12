<?php
class Ccc_Filetransfer_Model_Configuration extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('filetransfer/configuration');
    }

    public function fetchFiles()
    {
        $ftpModel = Mage::getModel('filetransfer/ftp');

        $ftpModel->setConfigObject($this);
        $ftpModel->getFiles();
    }
}
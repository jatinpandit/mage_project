<?php

class Ccc_VendorInventory_Adminhtml_ConfigurationController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        //    print_r( Mage::getModel('vendorinventory/configuration')->getResource()->getTable('configuration'));
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('vendorinventory/configuration')
        ;
        return $this;
    }

    public function indexAction()
    {
        $this->_initAction();
        $this->renderLayout();
        // echo 123852;   
    }


    public function getheadersAction()
    {
        $file = $_FILES['file'];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errorMessage = 'File upload failed with error code: ' . $file['error'];
            $this->getResponse()->setHeader('Content-type', 'application/json');
            $this->getResponse()->setBody(json_encode(['error' => $errorMessage]));
            return;
        }

        $filePath = $file['tmp_name'];
        $headers = [];

        if (!file_exists($filePath)) {
            $errorMessage = 'Uploaded file does not exist: ' . $filePath;
            $this->getResponse()->setHeader('Content-type', 'application/json');
            $this->getResponse()->setBody(json_encode(['error' => $errorMessage]));
            return;
        }

        if (($handle = fopen($filePath, 'r')) !== false) {
            $data = fgetcsv($handle, 1000, ',');
            if ($data !== false) {
                $headers = $data;

            } else {

                error_log('Failed to parse CSV data from file: ' . $filePath);
                // Set error response
                $errorMessage = 'Failed to read CSV data from file: ' . $filePath;
                $this->getResponse()->setHeader('Content-type', 'application/json');
                $this->getResponse()->setBody(json_encode(['error' => $errorMessage]));
                fclose($handle);
                return;
            }

        } else {
            $errorMessage = 'Failed to open file: ' . $filePath;
            $this->getResponse()->setHeader('Content-type', 'application/json');
            $this->getResponse()->setBody(json_encode(['error' => $errorMessage]));
            return;
        }

        fclose($handle);
        error_log('Headers: ' . print_r($headers, true));

        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody(json_encode(['headers' => $headers]));
    }

    public function checkBrandAction()
    {
        $brandId = $this->getRequest()->getPost('brandId');
        $response = [];

        $brandData = Mage::helper('vendorinventory')->checkBrand($brandId);
        if($brandData){
            $response['headers'] = explode(',',$brandData[0]['headers']);
            $response['configuration'] = $brandData[0]['brand_column_cofiguration'];

        }else{
            $response = [];
        }
        $this->getResponse()->setBody(json_encode($response));
    }
    public function saveAction()
    {
        try {

            $configuration = json_decode($this->getRequest()->getPost('configuration'));
            $header = $this->getRequest()->getPost('headers');
            // print_r($header);
            foreach ($configuration as $key => $val) {
                $brandId = $key;
                $columnConfig = $val;
            }
            // print_r($headers);
            $brandData = Mage::helper('vendorinventory')->checkBrand($brandId);
            // print_r($brandData);
            if ($brandData) {
                $data = [
                    'id' => $brandData[0]['id'],
                    'brand_id' => $brandData[0]['brand_id'],
                    'headers' =>  $header,
                ];
                $brandConfig = Mage::getModel('vendorinventory/configuration')->setData($data)->save();

                $data = [
                    'id' => $brandData[0]['id'],
                    'brand_table_id' => $brandData[0]['brand_table_id'],
                    'brand_column_cofiguration' => json_encode($columnConfig),
                ];
                $response = [];
                Mage::getModel('vendorinventory/configuration_column')->setData($data)->save();
                $this->getResponse()->setBody(json_encode($response));
            } else {
                $data = ['brand_id' => $brandId];
                $brandConfig = Mage::getModel('vendorinventory/configuration')->setData($data)->save();
                $data = [
                    'brand_table_id' => $brandConfig->getId(),
                    'brand_column_cofiguration' => json_encode($columnConfig),
                ];
                $response = ['headers'];
                Mage::getModel('vendorinventory/configuration_column')->setData($data)->save();
                $this->getResponse()->setBody(json_encode($response));
            }
        } catch (Exception $e) {
            $this->getResponse()->setBody('error: ' . $e->getMessage());
        }
    }
}
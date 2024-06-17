<?php
class Ccc_Filetransfer_Adminhtml_FiletransferController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('filetransfer')
            ->_addBreadcrumb(Mage::helper('filetransfer')->__('Config'), Mage::helper('filetransfer')->__('Config'))
            ->_addBreadcrumb(Mage::helper('filetransfer')->__('Manage Config'), Mage::helper('filetransfer')->__('Manage Config'))
        ;
        return $this;
    }

    public function indexAction()
    {
        $this->_title($this->__('Config'))
            ->_title($this->__('Config'))
            ->_title($this->__('Manage Config'));

        $this->_initAction();
        $this->renderLayout();
    }

    public function newAction()
    {
        // the same form is used to create and edit
        $this->_forward('edit');
    }
    public function editAction()
    {
        $this->_title($this->__('Config'))
            ->_title($this->__('Config'))
            ->_title($this->__('Manage Config'));

        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('config_id');
        $model = Mage::getModel('filetransfer/configuration');

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getConfigId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('filetransfer')->__('This Config no longer exists.')
                );
                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_title($model->getConfigId() ? $model->getUserName() : $this->__('New Config'));

        // 3. Set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        // 4. Register model to use later in blocks
        Mage::register('ccc_filetransfer', $model);

        // 5. Build edit form
        $this->_initAction()
            ->_addBreadcrumb(
                $id ? Mage::helper('filetransfer')->__('Edit config')
                : Mage::helper('filetransfer')->__('New config'),
                $id ? Mage::helper('filetransfer')->__('Edit config')
                : Mage::helper('filetransfer')->__('New config')
            );

        $this->renderLayout();
    }
    public function saveAction()
    {

        // check if data sent
        if ($data = $this->getRequest()->getPost()) {
            $id = $this->getRequest()->getParam('config_id');
            $model = Mage::getModel('filetransfer/configuration')->load($id);
            if (!$model->getConfigId() && $id) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('filetransfer')->__('This config no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }

            // init model and set data

            $model->setData($data);

            // try to save it
            try {
                // save the data
                $model->save();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('filetransfer')->__('The config has been saved.'));
                // clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('config_id' => $model->getConfigId()));
                    return;
                }
                // go to grid
                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {
                // display error message
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                // save data in session
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                // redirect to edit form
                $this->_redirect('*/*/edit', array('config_id' => $this->getRequest()->getParam('config_id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }

    /**
     * Delete action
     */
    public function deleteAction()
    {
        
        if ($id = $this->getRequest()->getParam('config_id')) {
            $name = '';
            try {
                
                $model = Mage::getModel('filetransfer/configuration');
                $model->load($id);
                $name = $model->getUserName();
                $model->delete();
                
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('filetransfer')->__('The config has been deleted.'));
                
                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {
                
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                
                $this->_redirect('*/*/edit', array('config_id' => $id));
                return;
            }
        }
 
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('filetransfer')->__('Unable to find a config to delete.'));
        
        $this->_redirect('*/*/');
    }

    public function renderfileAction()
    {
        $this->_title($this->__('File'))
            ->_title($this->__('File'))
            ->_title($this->__('Manage File'));

        $this->loadLayout()
            ->_setActiveMenu('filetransfer')
            ->_addBreadcrumb(Mage::helper('filetransfer')->__('File'), Mage::helper('filetransfer')->__('File'))
            ->_addBreadcrumb(Mage::helper('filetransfer')->__('Manage File'), Mage::helper('filetransfer')->__('Manage File'))
        ;
        $this->renderLayout();
    }

    public function extractAction()
    {
        $filename = $this->getRequest()->getParam('filename');
        $ConfigId = $this->getRequest()->getParam('config_id');
        $zipModel = Mage::getModel('filetransfer/zip');
        $zipModel->extractFile($filename, $ConfigId);
        $this->_redirect('*/*/renderfile');
    }

    public function exportAction()
    {
        echo "<pre>";
        $filename = $this->getRequest()->getParam('filename');
        $filename = str_replace('_','/',$filename);
        $filePath = Mage::getBaseDir('var') . DS . 'filetransfer' . $filename;
        // echo $filename;

        $xml = simplexml_load_file($filePath);
        // print_r($xml);
        $csvpath = Mage::getBaseDir('var').DS.'filetransfer'.DS.'csv'.DS.pathinfo($filename, PATHINFO_FILENAME).'.csv' ;
        // echo $csvpath;

        $rows = Mage::helper('filetransfer')->getRow();

        // print_r($rows);

        $xmlData = $this->readXml($xml, $rows);
        // print_r($xmlData);die;
        $this->writeCsv($xmlData, $csvpath);
        $this->_redirect('*/*/renderfile');

    }

    public function readXml($xml, $rows)
    {
        $result = [];

        foreach($xml->xpath('//items/item') as $item){
            $data = [];
            foreach($rows as $row){
                $attribute = $row['attribute'];
                $parts = explode('.', $row['parts']);
                // print_r($attribute);
                // print_r($parts);

                $currentElement = $item;

                for($i = 2; $i < count($parts); $i++){
                    $currentElement = $currentElement->{$parts[$i]};
                }

                if($row['attribute'] == 'itemNumber'){
                    $values = [];
                    foreach($currentElement as $element){
                        $values[] = (string)$element[$attribute];
                    }
                    // print_r($values);die;
                    $data['partNumber'] = implode(',',$values);
                } else{
                    $data[$parts[count($parts)-1]] = (string)$currentElement[$attribute];
                }
            }
            $result[] = $data;
        }
        return $result;
    }

    public function writeCsv($data, $csvFile)
    {
        $filePaths = [];
        $csv = '';

        $headerRow = array_keys($data[0]);
        $csv .= implode(',', $headerRow) . "\n";

        foreach ($data as $row) {
            $csvRow = array_map(function ($value) {
                return '"' . str_replace('"', '""', $value) . '"';
            }, $row);
            $csv .= implode(',', $csvRow) . "\n";
        }

        file_put_contents($csvFile, $csv);

        return $filePaths;  
    }


}
<?php

class Ccc_VendorInventory_Adminhtml_ConfigurationController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
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

    public function newAction()
    {
        // the same form is used to create and edit
        $this->_forward('edit');
    }

    public function editAction()
    {
        $this->_title($this->__('VendorInventory'))
            ->_title($this->__('Configuration'))
            ->_title($this->__('Manage Configuration'));

        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('configuration_id');
        $model = Mage::getModel('vendorinventory/configuration');

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('vendorinventory')->__('This Configuration no longer exists.')
                );
                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Configuration'));

        // 3. Set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        // 4. Register model to use later in blocks
        Mage::register('ccc_vendorinventory', $model);

        // 5. Build edit form
        $this->_initAction()
            ->_addBreadcrumb(
                $id ? Mage::helper('vendorinventory')->__('Edit Configuration')
                : Mage::helper('vendorinventory')->__('New Configuration'),
                $id ? Mage::helper('vendorinventory')->__('Edit Configuration')
                : Mage::helper('vendorinventory')->__('New Configuration')
            );

        $this->renderLayout();
    }

    public function saveAction()
    {

        // echo 111;die;
        // check if data sent
        if ($data = $this->getRequest()->getPost()) {
            $id = $this->getRequest()->getParam('configuration_id');
            $model = Mage::getModel('vendorinventory/configuration')->load($id);
            if (!$model->getId() && $id) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendorinventory')->__('This configuration no longer exists.'));
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
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('vendorinventory')->__('The configuration has been saved.'));
                // clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('banner_id' => $model->getId()));
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
                $this->_redirect('*/*/edit', array('configuration_id' => $this->getRequest()->getParam('configuration_id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        // check if we know what should be deleted
        if ($id = $this->getRequest()->getParam('configuration_id')) {
            $title = "";
            try {
                // init model and delete
                $model = Mage::getModel('vendorinventory/configuration');
                $model->load($id);
                $title = $model->getTitle();
                $model->delete();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('vendorinventory')->__('The configuration has been deleted.')
                );
                // go to grid
                Mage::dispatchEvent('adminhtml_banner_on_delete', array('title' => $title, 'status' => 'success'));
                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {
                Mage::dispatchEvent('adminhtml_banner_on_delete', array('title' => $title, 'status' => 'fail'));
                // display error message
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                // go back to edit form
                $this->_redirect('*/*/edit', array('configuration_id' => $id));
                return;
            }
        }
        // display error message
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendorinventory')->__('Unable to find a configuration to delete.'));
        // go to grid
        $this->_redirect('*/*/');
    }
}
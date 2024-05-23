<?php

class Ccc_Productseller_Adminhtml_ProductsellerController extends Mage_Adminhtml_Controller_Action
{
    public function _initAction()
    {
        // echo 111;
        $this->loadLayout();
        return $this;

    }

    // public function indexAction()
    // {
    //     $this->_title($this->__('Productseller'))->_title($this->__('Manage Productsellers'));
    //     $this->loadLayout();
    //     $this->_setActiveMenu('productseller/manage');
    //     $this->_addContent($this->getLayout()->createBlock('productseller/adminhtml_productseller'));
    //     $this->renderLayout();
    // }


    public function indexAction()
    {
        $this->_title($this->__('ProductSeller'));
        $this->_initAction();
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    // public function editAction()
    // {
    //     // echo 11;
    //     $this->_title($this->__('Productseller'));

    //     // 1. Get ID and create model
    //     $id = $this->getRequest()->getParam('id');
    //     $model = Mage::getModel('ccc_productseller/productseller');

    //     // 2. Initial checking
    //     if ($id) {
    //         $model->load($id);
    //         if (!$model->getId()) {
    //             Mage::getSingleton('adminhtml/session')->addError(
    //                 Mage::helper('productseller')->__('This Seller no longer exists.')
    //             );
    //             $this->_redirect('*/*/');
    //             return;
    //         }
    //     }

    //     $this->_title($model->getId() ? $model->getTitle() : $this->__('New Seller'));

    //     // 3. Set entered data if was error when we do save
    //     $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
    //     if (!empty($data)) {
    //         $model->setData($data);
    //     }

    //     // 4. Register model to use later in blocks
    //     Mage::register('ccc_productseller', $model);

    //     // 5. Build edit form
    //     $this->_initAction()
    //         ->_addBreadcrumb(
    //             $id ? Mage::helper('banner')->__('Edit Seller')
    //             : Mage::helper('banner')->__('New Seller'),
    //             $id ? Mage::helper('banner')->__('Edit Seller')
    //             : Mage::helper('banner')->__('New Seller')
    //         );

    //     $this->renderLayout();
    // }

    public function editAction()
    {
        $this->_title($this->__('Seller'))
            ->_title($this->__('Seller'))
            ->_title($this->__('Manage Seller'));

        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('ccc_productseller/productseller');
       

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('productseller')->__('This Seller no longer exists.')
                );
                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Seller'));

        // 3. Set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        // 4. Register model to use later in blocks
        Mage::register('ccc_productseller', $model);

        // 5. Build edit form
        $this->_initAction();
            // ->_addBreadcrumb(
            //     $id ? Mage::helper('productseller')->__('Edit seller')
            //     : Mage::helper('productseller')->__('New seller'),
            //     $id ? Mage::helper('productseller')->__('Edit seller')
            //     : Mage::helper('productseller')->__('New seller')
            // );
            // echo 
        $this->renderLayout();
    }
    public function saveAction()
    {

        // echo 111;die;
        // check if data sent
        if ($data = $this->getRequest()->getPost()) {

            $id = $this->getRequest()->getParam('id');
            $model = Mage::getModel('ccc_productseller/productseller')->load($id);
            if (!$model->getId() && $id) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('productseller')->__('This seller no longer exists.'));
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
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('productseller')->__('The seller has been saved.'));
                // clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
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
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        // check if we know what should be deleted
        if ($id = $this->getRequest()->getParam('id')) {
            $title = "";
            try {
                // init model and delete
                $model = Mage::getModel('ccc_productseller/productseller');
                $model->load($id);
                $title = $model->getTitle();
                $model->delete();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('productseller')->__('The seller has been deleted.')
                );
                // go to grid
                Mage::dispatchEvent('adminhtml_productseller_on_delete', array('title' => $title, 'status' => 'success'));
                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {
                Mage::dispatchEvent('adminhtml_productseller_on_delete', array('title' => $title, 'status' => 'fail'));
                // display error message
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                // go back to edit form
                $this->_redirect('*/*/edit', array('id' => $id));
                return;
            }
        }
        // display error message
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('productseller')->__('Unable to find a seller to delete.'));
        // go to grid
        $this->_redirect('*/*/');
    }

    protected function _isAllowed()
    {
        // $aclResource = null;
        $action = strtolower($this->getRequest()->getActionName());
        switch ($action) {
            case 'productseller_index':
                $aclResource = 'productseller/sellergrid';
                break;
            case 'sellerreport_index':
                $aclResource = 'productseller/sellerreport';
                break;
                default:
                $aclResource = 'productseller';
                break;
        }
        // var_dump($aclResource);
        return Mage::getSingleton('admin/session')->isAllowed($aclResource);
    }

}
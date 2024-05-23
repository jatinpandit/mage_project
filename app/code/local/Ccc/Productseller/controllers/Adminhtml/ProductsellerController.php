<?php

class Ccc_Productseller_Adminhtml_ProductsellerController extends Mage_Adminhtml_Controller_Action
{
    public function _initAction()
    {
        // echo 111;
        $this->loadLayout();
        return $this;

    }

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
        $this->_initAction()
            ->_addBreadcrumb(
                $id ? Mage::helper('productseller')->__('Edit seller')
                : Mage::helper('productseller')->__('New seller'),
                $id ? Mage::helper('productseller')->__('Edit seller')
                : Mage::helper('productseller')->__('New seller')
            );
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

            // $data['updated_date'] = date('d-m-Y');

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

    public function massUpdateIsActiveAction() {
        $sellerIds     = (array)$this->getRequest()->getParam('seller_ids');
        $IsActive     = (int)$this->getRequest()->getParam('is_active');

        try {
            foreach ($sellerIds as $sellerId) {
                $sellerId = Mage::getModel('ccc_productseller/productseller')->load($sellerId);
                $sellerId->setIsActive($IsActive);
                $sellerId->save();
            }
        }
        catch (Mage_Core_Model_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (Exception $e) {
            $this->_getSession()
                ->addException($e, $this->__('An error occurred while updating the product(s) status.'));
        }

        // $this->_redirect('*/*/', array('store'=> $storeId));

        $this->_redirect('*/*/');
    }

}
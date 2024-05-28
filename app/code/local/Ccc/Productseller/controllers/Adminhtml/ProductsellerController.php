<?php

class Ccc_Productseller_Adminhtml_ProductsellerController extends Mage_Adminhtml_Controller_Action
{
    public function _initAction()
    {
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

        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('ccc_productseller/productseller');



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

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('ccc_productseller', $model);

        $this->_initAction()
            ->_addBreadcrumb(
                $id ? Mage::helper('productseller')->__('Edit seller')
                : Mage::helper('productseller')->__('New seller'),
                $id ? Mage::helper('productseller')->__('Edit seller')
                : Mage::helper('productseller')->__('New seller')
            );
        $this->renderLayout();
    }
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {

            $id = $this->getRequest()->getParam('id');
            $model = Mage::getModel('ccc_productseller/productseller')->load($id);
            if (!$model->getId() && $id) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('productseller')->__('This seller no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }

            $model->setData($data);


            try {

                $model->save();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('productseller')->__('The seller has been saved.'));

                Mage::getSingleton('adminhtml/session')->setFormData(false);


                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }

                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {

                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());

                Mage::getSingleton('adminhtml/session')->setFormData($data);

                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            $title = "";
            try {

                $model = Mage::getModel('ccc_productseller/productseller');
                $model->load($id);
                $title = $model->getTitle();
                $model->delete();

                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('productseller')->__('The seller has been deleted.')
                );
                Mage::dispatchEvent('adminhtml_productseller_on_delete', array('title' => $title, 'status' => 'success'));
                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {
                Mage::dispatchEvent('adminhtml_productseller_on_delete', array('title' => $title, 'status' => 'fail'));
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $id));
                return;
            }
        }

        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('productseller')->__('Unable to find a seller to delete.'));

        $this->_redirect('*/*/');
    }

    protected function _isAllowed()
    {
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
        return Mage::getSingleton('admin/session')->isAllowed($aclResource);
    }

    public function massUpdateIsActiveAction()
    {
        $sellerIds = (array) $this->getRequest()->getParam('seller_ids');
        $IsActive = (int) $this->getRequest()->getParam('is_active');

        try {
            foreach ($sellerIds as $sellerId) {
                $sellerId = Mage::getModel('ccc_productseller/productseller')->load($sellerId);
                $sellerId->setIsActive($IsActive);
                $sellerId->save();
            }
        } catch (Mage_Core_Model_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (Exception $e) {
            $this->_getSession()
                ->addException($e, $this->__('An error occurred while updating the product(s) status.'));
        }

        $this->_redirect('*/*/');
    }

}
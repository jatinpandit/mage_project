<?php

class Ccc_Outlook_Adminhtml_OutlookController extends Mage_Adminhtml_Controller_Action
{

    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('outlook')
            ->_addBreadcrumb(Mage::helper('outlook')->__('Email'), Mage::helper('outlook')->__('Email'))
            ->_addBreadcrumb(Mage::helper('outlook')->__('Manage Email'), Mage::helper('outlook')->__('Manage Emial'))
        ;
        return $this;
    }

    public function indexAction()
    {
        $this->_title($this->__('Configuration'))
            ->_title($this->__('Email'))
            ->_title($this->__('Manage Email'));

        $this->_initAction();
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }
    public function editAction()
    {
        $this->_title($this->__('Configuration'))
            ->_title($this->__('Email'))
            ->_title($this->__('Manage Email'));

        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('outlook/outlook');

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('outlook')->__('This Email no longer exists.')
                );
                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_title($model->getId() ? $model->getUserName() : $this->__('New Email'));

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('ccc_outlook', $model);

        $this->_initAction()
            ->_addBreadcrumb(
                $id ? Mage::helper('outlook')->__('Edit email')
                : Mage::helper('outlook')->__('New email'),
                $id ? Mage::helper('outlook')->__('Edit email')
                : Mage::helper('outlook')->__('New email')
            );

        $this->renderLayout();
    }
    public function saveAction()
    {

        if ($data = $this->getRequest()->getPost()) {

            $id = $this->getRequest()->getParam('id');
            $model = Mage::getModel('outlook/outlook')->load($id);
            if (!$model->getId() && $id) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('outlook')->__('This email no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }

            

            $model->setData($data);


            try {
                
                $model->save();
                
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('outlook')->__('The email has been saved.'));
                
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
            try {
                
                $model = Mage::getModel('outlook/outlook');
                $model->load($id);
                $model->delete();
                
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('outlook')->__('The email has been deleted.'));
                
                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());

                $this->_redirect('*/*/edit', array('id' => $id));
                return;
            }
        }
        
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('outlook')->__('Unable to find a outlook to delete.'));
        $this->_redirect('*/*/');
    }


}
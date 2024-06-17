<?php

class Ccc_Ticket_Adminhtml_TicketController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('ticket');
        return $this;
    }

    public function indexAction()
    {
        $this->_initAction();
        $this->renderLayout();
    }

    public function saveAction()
    {

        // check if data sent
        if ($data = $this->getRequest()->getPost()) {
            // print_r($data);die;
            $id = $this->getRequest()->getParam('ticket_id');
            $model = Mage::getModel('ticket/ticket')->load($id);
            if (!$model->getConfigId() && $id) {
                // Mage::getSingleton('adminhtml/session')->addError(Mage::helper('ticket')->__('This config no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }

            // init model and set data
            $data['assigned_by'] = Mage::getSingleton('admin/session')->getUser()->getId();
            $data['updated_at'] = date('d-m-Y');
            // print_r($data);die;

            $model->setData($data);

            // try to save it
            try {
                // save the data
                $model->save();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('ticket')->__('The ticket has been submitted.'));
                // clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                // check if 'Save and Continue'
                // if ($this->getRequest()->getParam('back')) {
                //     $this->_redirect('*/*/edit', array('config_id' => $model->getConfigId()));
                //     return;
                // }
                // go to grid
                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {
                // display error message
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                // save data in session
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                // redirect to edit form
                // $this->_redirect('*/*/edit', array('config_id' => $this->getRequest()->getParam('config_id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }

    public function viewAction()
    {
        // echo 111;
        $this->loadLayout();
        $this->renderLayout();
    }
}
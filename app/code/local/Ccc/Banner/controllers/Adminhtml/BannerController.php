<?php

class Ccc_Banner_Adminhtml_BannerController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('banner/banner')
            // ->_addBreadcrumb(Mage::helper('banner')->__('Banner'), Mage::helper('banner')->__('Banner'))
            // ->_addBreadcrumb(Mage::helper('banner')->__('Manage Banner'), Mage::helper('banner')->__('Manage Banner'))
        ;
        return $this;
    }

    public function indexAction()
    {
        // var_dump(!(int)(1));
        $this->_title($this->__('Banner'))
            ->_title($this->__('Banner'))
            ->_title($this->__('Manage Banner'));
        // $this->loadLayout();
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
        $this->_title($this->__('Banner'))
            ->_title($this->__('Banner'))
            ->_title($this->__('Manage Banner'));

        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('banner_id');
        $model = Mage::getModel('banner/banner');

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('banner')->__('This Banner no longer exists.')
                );
                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Banner'));

        // 3. Set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        // 4. Register model to use later in blocks
        Mage::register('ccc_banner', $model);

        // 5. Build edit form
        $this->_initAction()
            ->_addBreadcrumb(
                $id ? Mage::helper('banner')->__('Edit Banner')
                : Mage::helper('banner')->__('New Banner'),
                $id ? Mage::helper('banner')->__('Edit Banner')
                : Mage::helper('banner')->__('New Banner')
            );

        $this->renderLayout();
    }

    public function saveAction()
    {

        // echo 111;die;
        // check if data sent
        if ($data = $this->getRequest()->getPost()) {
            $type = 'banner_image';

            if (isset($data[$type]['delete'])) {
                Mage::helper('banner')->deleteImageFile($data[$type]['value']);
            }
            $image = Mage::helper('banner')->uploadBannerImage($type);
            if ($image || (isset($data[$type]['delete']) && $data[$type]['delete'])) {
                $data[$type] = $image;
            } else {
                unset($data[$type]);
            }

            $id = $this->getRequest()->getParam('banner_id');
            $model = Mage::getModel('banner/banner')->load($id);
            if (!$model->getId() && $id) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('banner')->__('This banner no longer exists.'));
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
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('banner')->__('The banner has been saved.'));
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
                $this->_redirect('*/*/edit', array('banner_id' => $this->getRequest()->getParam('banner_id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        // check if we know what should be deleted
        if ($id = $this->getRequest()->getParam('banner_id')) {
            $title = "";
            try {
                // init model and delete
                $model = Mage::getModel('banner/banner');
                $model->load($id);
                $title = $model->getTitle();
                $model->delete();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('banner')->__('The banner has been deleted.')
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
                $this->_redirect('*/*/edit', array('banner_id' => $id));
                return;
            }
        }
        // display error message
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('banner')->__('Unable to find a banner to delete.'));
        // go to grid
        $this->_redirect('*/*/');
    }

    protected function _isAllowed()
    {
        // $aclResource = null;
        $action = strtolower($this->getRequest()->getActionName());
        switch ($action) {
            case 'index':
                $aclResource = 'banner/page/actions/index';
                break;
            case 'addButton':
                $aclResource = 'banner/page/actions/addButton';
                break;
            case 'new':
                $aclResource = 'banner/page/actions/new';
                break;
            case 'edit':
                $aclResource = 'banner/page/actions/edit';
                break;
            case 'save':
                $aclResource = 'banner/page/actions/save';
                break;
            case 'show_title':
                $aclResource = 'banner/page/actions/show_title';
                break;
            case 'show_all':
                $aclResource = 'banner/page/actions/show_all';
                break;
            default:
                $aclResource = 'banner/banner';
                break;
        }
        return Mage::getSingleton('admin/session')->isAllowed($aclResource);
    }
}
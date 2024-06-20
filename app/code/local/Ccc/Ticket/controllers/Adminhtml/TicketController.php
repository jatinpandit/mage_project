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
        $filter_id = $this->getRequest()->getParam('filter_id');
        $page = $this->getRequest()->getParam('page', 1);
        $pageSize = 10;

        // var_dump($filter_id);     
        $ticketCollection = Mage::getModel('ticket/ticket')->getCollection();

        if ($filter_id) {
            $filterModel = Mage::getModel('ticket/filter')->load($filter_id);
            $ticketCollection->addFieldToFilter(
                'assigned_to',
                array('in' => explode(',', $filterModel->getAssignedTo()))
            );
            $ticketCollection->addFieldToFilter(
                'status',
                array('in' => explode(',', $filterModel->getStatus()))
            );

            $datetime = new DateTime();
            $fromdate = $datetime->modify("-{$filterModel->getCreatedAt()}days")->format('Y-m-d H:i:s');
            $ticketCollection->addFieldToFilter('created_at', array('gteq' => $fromdate));
            // var_dump($fromdate);

            $commentCollection = Mage::getModel('ticket/comment')->getCollection();
            $subquery = new Zend_Db_Expr(
                '(SELECT MAX(comment_id) FROM ccc_ticket_comment GROUP BY ticket_id)'
            );
            $commentCollection->getSelect()
                ->where('main_table.comment_id IN ' . $subquery)
                ->order('main_table.created_at DESC');

            if ($filterModel->getLastComment()) {
                $commentCollection->addFieldToFilter('user_id', $filterModel->getLastComment());
            }
            // var_dump($commentCollection->getData());

            $result = [];
            foreach ($commentCollection as $_comment) {
                $result[] = $_comment->getTicketId();
            }
            // print_r($result);

            $ticketCollection->addFieldToFilter('ticket_id', array('in' => $result));
        }

        $ticketCollection->setPageSize($pageSize);
        $ticketCollection->setCurPage($page);
        // $ticketCollection->getSelect()->limit($pageSize, ((int) $page - 1) * (int) $pageSize);
        Mage::register('current_page', $page);
        Mage::register('total_pages', ceil($ticketCollection->getSize() / $pageSize));
        Mage::register('ticket_collection', $ticketCollection);

        $this->_initAction();
        $this->_setActiveMenu('ticket');
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

                $this->_redirect('*/*/');
                return;
            }

            $data['assigned_by'] = Mage::getSingleton('admin/session')->getUser()->getId();



            $model->setData($data);

            try {

                $model->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('ticket')->__('The ticket has been submitted.'));

                Mage::getSingleton('adminhtml/session')->setFormData(false);
                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {

                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());

                Mage::getSingleton('adminhtml/session')->setFormData($data);
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
        // $this->getRequest()->getParam('ticket_id');
    }

    public function saveCommentAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $data['user_id'] = Mage::getSingleton('admin/session')->getUser()->getId();
            $data['updated_at'] = date('d-m-Y H:i:s');
            // print_r($data);
            $model = Mage::getModel('ticket/comment');

            $model->setData($data)->save();
        }
        $this->_redirect('*/*/index');
    }

    public function saveFilterAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            // $status = array_values($data['status']);
            $data['status'] = implode(',', array_values($data['status']));
            $data['assigned_to'] = implode(',', array_values($data['assigned_to']));
            // print_r($data);
            $model = Mage::getModel('ticket/filter');
            $model->setData($data)->save();
        }
        $this->_redirect('*/*/index');
    }

    public function saveDropdownAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            // print_r($data);
            $temp = [];
            $temp['ticket_id'] = $data['ticket_id'];
            $temp[$data['field']] = $data['val'];
            $model = Mage::getModel('ticket/ticket');
            $model->setData($temp)->save();
        }
    }

    // public function filterAction()
    // {
    //     $filterModel = Mage::getModel('ticket/filter')->load($filter_id);
    //         $ticketCollection->addFieldToFilter(
    //             'assigned_to',
    //             array('in' => explode(',', $filterModel->getAssignedTo()))
    //         );
    //         $ticketCollection->addFieldToFilter(
    //             'status',
    //             array('in' => explode(',', $filterModel->getStatus()))
    //         );

    //         $datetime = new DateTime();
    //         $fromdate = $datetime->modify("-{$filterModel->getDays()}days")->format('Y-m-d H:i:s');

    //         $ticketCollection->addFieldToFilter('created_at', array('gteq' => $fromdate));

    //         $commentCollection = Mage::getModel('ticket/comment')->getCollection();
    //         $subquery = new Zend_Db_Expr(
    //             '(SELECT MAX(comment_id) FROM ccc_ticket_comment GROUP BY ticket_id)'
    //         );
    //         $commentCollection->getSelect()
    //             ->where('main_table.comment_id IN ' . $subquery)
    //             ->order('main_table.created_at DESC');

    //         $commentCollection->addFieldToFilter('user_id', $filterModel->getUser());

    //         $result = [];
    //         foreach ($commentCollection as $_comment) {
    //             $result[] = $_comment->getTicketId();
    //         }

    //         $ticketCollection->addFieldToFilter('ticket_id', array('in'=>$result));
    // }
}
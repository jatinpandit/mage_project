<?php
class Ccc_Outlook_Block_Adminhtml_Outlook_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('email_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('outlook')->__('Configuration Information'));
    }
}
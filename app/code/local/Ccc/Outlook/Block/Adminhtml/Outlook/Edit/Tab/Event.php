<?php
class Ccc_Outlook_Block_Adminhtml_Outlook_Edit_Tab_Event extends Mage_Adminhtml_Block_Widget implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

    public function getTabLabel()
    {
        return Mage::helper('outlook')->__('Event Information');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('outlook')->__('Event Information');
    }

    /**
     * Returns status flag about this tab can be shown or not
     *
     * @return true
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Returns status flag about this tab hidden or not
     *
     * @return true
     */
    public function isHidden()
    {
        return true;
    }

}
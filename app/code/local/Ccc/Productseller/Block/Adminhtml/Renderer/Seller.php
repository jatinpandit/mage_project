<?php
class Ccc_Productseller_Block_Adminhtml_Renderer_Seller extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $sellerId = $row->getData($this->getColumn()->getIndex());


        $companyName = Mage::getSingleton('core/resource')->getConnection('core_read')
            ->select()
            ->from(array('seller' => 'ccc_seller'), 'company_name')
            ->where('seller.id = ?', $sellerId)
            ->limit(1)
            ->query()
            ->fetchColumn();

        return $companyName;
    }
}

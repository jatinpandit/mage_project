<?php

class Ccc_Productseller_Block_Adminhtml_Report_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        // echo 111;
        parent::__construct();
        // $this->setId('productsellerGrid');
        // $this->setDefaultSort('id');
        // $this->setDefaultDir('Asc');
        $this->setTemplate('productseller/report.phtml');

    }
}
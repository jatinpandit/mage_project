<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

/**
 * Create table 'cms/block'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('ccc_vendorinventory_configuration'))
    ->addColumn('configuration_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Configuration ID')
    ->addColumn('configuration_name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Configuration Name')
    ->addColumn('file_format', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'File Format')
        ->addColumn('file_name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
            'nullable'  => false,
            ), 'File Name')
    ->setComment('CCC VendorInventory Configuration Table');
$installer->getConnection()->createTable($table);

$table = $installer->getConnection()
            ->newTable($installer->getTable('ccc_vendorinventory_configuration_rule'))
            ->addColumn('rule_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
                'identity' => true,
                'nullable' => false,
                'primary' => true,
            ), 'Configuration Rule Id')
            ->addColumn('part_number', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
                'nullable' => false 
            ),'Part Number')
            ->addColumn('part_name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
                'nullable' => false
            ),'Part Name')
            ->addColumn('instock_qty', Varien_Db_Ddl_Table::TYPE_NUMERIC, null, array(
                'nullable' => false
            ),'Instock Quantity')
            ->addColumn('restock_date', Varien_Db_Ddl_Table::TYPE_DATE, null, array(
                'nullable' => false
            ),'Restock Date')
            ->addColumn('restock_qty', Varien_Db_Ddl_Table::TYPE_NUMERIC, null, array(
                'nullable' => false
            ), 'Restock Quantity')
            ->addColumn('price', Varien_Db_Ddl_Table::TYPE_NUMERIC, null, array(
                'nullable' => false
            ),'Price')
            ->setComment('CCC VendorInventory Configuration Rule Table');
$installer->getConnection()->createTable($table);

$table = $installer->getConnection()
            ->newTable($installer->getTable('ccc_vendorinventory_instock_date'))
            ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
                'identity' => true,
                'nullable' => false,
                'primary' => true,
            ), 'Product Id')
            ->addColumn('product_name', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
                'nullable' => false 
            ),'Product Name')
            ->addColumn('sku', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
                'nullable' => false 
            ),'Product SKU')
            ->addColumn('instock_date', Varien_Db_Ddl_Table::TYPE_DATE, null, array(
                'nullable' => false 
            ),'Instock Date')
            ->addColumn('available_qty', Varien_Db_Ddl_Table::TYPE_NUMERIC, null, array(
                'nullable' => false 
            ),'Available Quantity')
            ->addColumn('next_available_qty', Varien_Db_Ddl_Table::TYPE_NUMERIC, null, array(
                'nullable' => false 
            ),'Next Available Quantity')
            ->addColumn('restock_days', Varien_Db_Ddl_Table::TYPE_NUMERIC, null, array(
                'nullable' => false 
            ),'Restock Days')
            ->addColumn('price', Varien_Db_Ddl_Table::TYPE_NUMERIC, null, array(
                'nullable' => false 
            ),'Price')
            ->addColumn('created_date', Varien_Db_Ddl_Table::TYPE_DATE, null, array(
                'nullable' => false 
            ),'Created Date')
            ->addColumn('ship_date', Varien_Db_Ddl_Table::TYPE_DATE, null, array(
                'nullable' => false 
            ),'Ship Date')
            ->addColumn('product_status', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
                'nullable' => false 
            ),'Product Status')
            ->setComment('CCC VendorInventory Product Instock Date Table');
$installer->getConnection()->createTable($table);
$installer->endSetup();


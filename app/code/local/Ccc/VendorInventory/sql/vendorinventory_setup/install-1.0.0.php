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
            ->newTable($installer->getTable('ccc_vendorinventory_brand_configuration'))
            ->addColumn('id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
                'identity' => true,
                'nullable' => false,
                'primary' => true,
            ), 'Id')
            ->addColumn('brand_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
                'nullable' => false 
            ),'Brand Id')
            ->setComment('CCC VendorInventory Configuration Rule Table');
$installer->getConnection()->createTable($table);

$table = $installer->getConnection()
            ->newTable($installer->getTable('ccc_vendorinventory_column_configuration'))
            ->addColumn('id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
                'identity' => true,
                'nullable' => false,
                'primary' => true,
            ), 'Id')
            ->addColumn('brand_table_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array( 
                'nullable' => false 
            ),'Brand Table Id')
            ->addColumn('brand_column_configuration', Varien_Db_Ddl_Table::TYPE_TEXT,300, array(
                'nullable' => false
            ),'Brand Coloumn Configuration')
            ->setComment('CCC VendorInventory Configuration Rule Table');
$installer->getConnection()->createTable($table);

$installer->endSetup();


<?php

$installer = $this;
$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('ccc_vendorinventory_items'))
    ->addColumn('item_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity' => true,
        'nullable' => false,
        'primary' => true,
    ), 'Item ID')
    ->addColumn('brand_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable' => false
    ),'Brand Id')
    ->addColumn('sku', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => true
    ), 'SKU')
    ->addColumn('instock', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'=> true
    ), 'In Stock')
    ->addColumn('instock_qty', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'nullable'=> true
    ),'In Stock Qty')
    ->addColumn('restock_date', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => true
    ),"Restock Date")
    ->addColumn('restock_qty', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'nullable' => true
    ))
    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => true
    ))
    ->addColumn('discontinued', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => true
    ), 'Discontinued')
    ->setComment('CCC Inventory Item');
$installer->getConnection()->createTable($table);
$installer->endSetup();
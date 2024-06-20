<?php

$installer = $this;

$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('ccc_ticket_filter'))
    ->addColumn('filter_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'identity' => true,
        'nullable' => false,
        'primary' => true,
    ), 'Filter ID')
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_VARCHAR,255, array(
        'nullable' => true,
    ))
    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => true,
    ),'Status')
    ->addColumn('assigned_to', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => true,
    ), 'Assigned To')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'nullable' => true,
    ),'Created At')
    ->addColumn('last_comment', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable' => true,
    ), 'Last Comment')
    ->setComment('Ccc Ticket Filter Table');
$installer->getConnection()->createTable($table);
$installer->endSetup();
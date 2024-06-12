<?php

$installer = $this;

$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('ccc_outlook_configuration'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'identity' => true,
        'nullable' => false,
        'primary' => true,
    ), 'ID')
    ->addColumn('username', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => false,
    ), 'User Name')
    ->addColumn('password', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => false,
    ), 'Password')
    ->addColumn('api_url', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => false,
    ), 'Api Url')
    ->addColumn('api_key', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
    ), 'Api Key')
    ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable' => false,
    ), 'Is Active')
    ->setComment('CCC Outlook Configuration Table');
$installer->getConnection()->createTable($table);

$installer->endSetup();
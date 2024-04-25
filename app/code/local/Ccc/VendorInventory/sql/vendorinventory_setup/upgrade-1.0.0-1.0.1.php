<?php

$installer = $this;
$installer->startSetup();
$table = $installer->getTable('ccc_vendorinventory_brand_configuration');
$installer->getConnection()
->addColumn($table, 'headers', array(
    'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
    'nullable'  => false,
    'comment' => 'Headers'
    ));
$installer->endSetup();
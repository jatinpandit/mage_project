<?php

$installer = $this;

$installer->startSetup();

$entityTypeId = "catalog_product";
$attributeCode = "seller_id";
$attributeLabel = "Seller Id";

$sourceModel = 'ccc_productseller/attribute_source_seller';

$data = [
    "type" => 'text',
    "input" => 'select', 
    "label" => $attributeLabel,
    "source" => $sourceModel,
    "required" => true,
    "user_define" => true,
    "unique" => false,
];

// Add the attribute
$installer->addAttribute($entityTypeId, $attributeCode, $data);

$installer->endSetup();

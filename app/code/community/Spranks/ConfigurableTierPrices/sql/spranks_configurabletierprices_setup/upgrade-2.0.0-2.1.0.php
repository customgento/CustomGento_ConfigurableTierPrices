<?php

/** @var Mage_Catalog_Model_Resource_Setup $installer */
$installer = $this;
$installer->startSetup();

$attributeCode = Spranks_ConfigurableTierPrices_Helper_Data::ATTRIBUTE_DISABLED_FOR_PRODUCT;
$installer->addAttribute(
    Mage_Catalog_Model_Product::ENTITY, $attributeCode, array(
    'label'                   => 'Disable Spranks Configurable Tier Prices',
    'group'                   => 'General',
    'type'                    => 'int',
    'input'                   => 'select',
    'source'                  => 'eav/entity_attribute_source_boolean',
    'backend'                 => 'catalog/product_attribute_backend_boolean',
    'frontend'                => '',
    'global'                  => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'required'                => false,
    'default'                 => false,
    'user_defined'            => false,
    'filterable_in_search'    => false,
    'is_configurable'         => false,
    'used_in_product_listing' => true
)
);

$installer->endSetup();

<?php

class CustomGento_ConfigurableTierPrices_Helper_Data extends Mage_Core_Helper_Abstract
{

    const XML_PATH_IS_ENABLED = 'sales/customgento_configurabletierprices/is_enabled';
    const XML_PATH_DISABLED_FOR_CATEGORY = 'sales/customgento_configurabletierprices/disabled_for_category';

    // attribute code length must be less than 30 symbols!
    const ATTRIBUTE_DISABLED_FOR_PRODUCT = 'configtierprices_disabled';

    public function isAdmin()
    {
        if (Mage::app()->getStore()->isAdmin()) {
            return true;
        }

        if (Mage::getDesign()->getArea() == 'adminhtml') {
            return true;
        }

        return false;
    }

    public function isExtensionEnabled()
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_IS_ENABLED);
    }

    public function isProductInDisabledCategory(Mage_Catalog_Model_Product $product)
    {
        $disabledCategories = explode(',', Mage::getStoreConfig(self::XML_PATH_DISABLED_FOR_CATEGORY));
        $productCategories  = $product->getAvailableInCategories();
        if (!empty(array_intersect($disabledCategories, $productCategories))) {
            return true;
        }

        return false;
    }

    public function isExtensionDisabledForProduct(Mage_Catalog_Model_Product $product)
    {
        // get the product attribute directly, because it may not be loaded
        $configtierpricesDisabled = Mage::getResourceModel('catalog/product')->getAttributeRawValue(
            $product->getId(), self::ATTRIBUTE_DISABLED_FOR_PRODUCT, Mage::app()->getStore()
        );
        if ($configtierpricesDisabled) {
            return true;
        }

        return false;
    }

}

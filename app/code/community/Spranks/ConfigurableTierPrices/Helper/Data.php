<?php

class Spranks_ConfigurableTierPrices_Helper_Data extends Mage_Core_Helper_Abstract
{

    const XML_PATH_IS_ENABLED = 'spranks_configurabletierprices/general/is_enabled';
    const XML_PATH_DISABLED_FOR_CATEGORY = 'spranks_configurabletierprices/general/disabled_for_category';

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
        if (count(array_intersect($disabledCategories, $productCategories)) > 0) {
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

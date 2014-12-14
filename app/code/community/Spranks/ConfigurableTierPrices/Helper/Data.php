<?php

class Spranks_ConfigurableTierPrices_Helper_Data extends Mage_Core_Helper_Abstract
{

    const XML_PATH_IS_ENABLED = 'spranks_configurabletierprices/general/is_enabled';

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

}

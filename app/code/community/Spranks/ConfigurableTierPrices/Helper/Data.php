<?php

class Spranks_ConfigurableTierPrices_Helper_Data extends Mage_Core_Helper_Abstract
{

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

}

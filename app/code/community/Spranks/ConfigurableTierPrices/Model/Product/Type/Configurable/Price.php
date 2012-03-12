<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright   Copyright (c) 2010 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Product type price model
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Spranks_ConfigurableTierPrices_Model_Product_Type_Configurable_Price extends Mage_Catalog_Model_Product_Type_Configurable_Price
{
    /**
     * Get product final price
     *
     * @param   double $qty
     * @param   Mage_Catalog_Model_Product $product
     * @return  double
     */
    public function getFinalPrice($qty=null, $product)
    {
        $finalPrice = parent::getFinalPrice($qty, $product);
        // if tier prices are defined, also adapt them to configurable products
        // example: if a shirt is available in red and black and if you buy 
        // three or more the price is eight euro, you can also buy one red and 
        // two black shirts and you will get the tier price of eight euro.
		// based on https://www.magentocommerce.com/boards/viewthread/10743/
		if ($product->getTierPriceCount() > 0) {
			$tierPrice = $this->calcConfigProductTierPricing($product);
			if ($tierPrice < $finalPrice) {
				$finalPrice = $tierPrice;
			}
		}
		return $finalPrice;
    }

	/**
     * Get product final price via configurable product's tier pricing structure. 
	 * Uses qty of parent item to determine price.
     *
     * @param   Mage_Catalog_Model_Product $product
     * @return  float
     */
    public function calcConfigProductTierPricing($product)
    {
        $tierPrice = PHP_INT_MAX;

		if ($items = Mage::getSingleton('checkout/session')->getQuote()->getItemsCollection()) {
			// map mapping the IDs of the parent products with the quantities of the corresponding simple products
			$idQuantities = array();
			// go through all products in the quote
			foreach ($items as $item) {
				if ($item->getParentItem())
					continue;
				// get the simple products ID
				$productModel = Mage::getModel('catalog/product');
				$id = $productModel->getIdBySku($item->getSku());
				// get the parent IDs
				$configurableProductModel = Mage::getModel('catalog/product_type_configurable');
				$parentIdArray = $configurableProductModel->getParentIdsByChild($id);
				// map the parent ID with the quantities of the simple products
				foreach ($parentIdArray as $parent)
					$idQuantities[$parent][] = $item->getQty();
			}
			// compute the total quantity of items of the configurable product
			if (array_key_exists($product->getId(), $idQuantities)) {
				$totalQty = array_sum($idQuantities[$product->getId()]);
				$tierPrice = parent::getFinalPrice($totalQty, $product);
			}
		}
        return $tierPrice;
    }

}

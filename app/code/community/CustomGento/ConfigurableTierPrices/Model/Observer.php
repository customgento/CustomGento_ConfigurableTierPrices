<?php

class CustomGento_ConfigurableTierPrices_Model_Observer
{
    /**
     * @var CustomGento_ConfigurableTierPrices_Helper_Data
     */
    protected $helper;

    public function __construct()
    {
        $this->helper = Mage::helper('customgento_configurabletierprices');
    }

    /**
     * Applies the tier pricing structure across different variants of configurable products.
     *
     * @param  Varien_Event_Observer $observer
     *
     * @return CustomGento_ConfigurableTierPrices_Model_Observer
     */
    public function catalogProductGetFinalPrice(Varien_Event_Observer $observer)
    {
        $product = $observer->getProduct();

        if (!$this->helper->isExtensionEnabled() ||
            $this->helper->isProductInDisabledCategory($product) ||
            $this->helper->isExtensionDisabledForProduct($product)
        ) {
            return $this;
        }

        // Only apply to configurable products
        if (!$product->isConfigurable()) {
            return $this;
        }

        // Do not calculate tier prices based on cart items on product page
        // @see https://github.com/customgento/CustomGento_ConfigurableTierPrices/issues/14
        if (Mage::registry('current_product')) {
            return $this;
        }

        // If tier prices are defined, also adapt them to configurable products
        if ($product->getTierPriceCount() > 0) {
            $tierPrice = $this->calculateTierPrice($product);
            if ($tierPrice < $product->getData('final_price')) {
                $product->setData('final_price', $tierPrice);
            }
        }

        return $this;
    }

    /**
     * Calculate product final price via configurable product's tier pricing structure.
     *
     * Uses quantity of parent item to determine price.
     *
     * @param   Mage_Catalog_Model_Product $product
     *
     * @return  float
     */
    protected function calculateTierPrice($product)
    {
        $totalQuantity = $this->calculateTotalQuantity($product);

        if ($totalQuantity > 0) {
            return $product->getPriceModel()->getBasePrice($product, $totalQuantity);
        }

        return PHP_INT_MAX;
    }

    /**
     * Calculate total quantity of product in cart.
     *
     * @param  Mage_Catalog_Model_Product $product
     *
     * @return int
     */
    protected function calculateTotalQuantity($product)
    {
        return array_reduce($this->getAllVisibleItems(), function ($total, $item) use ($product) {
            if ($item->getProductId() == $product->getId()) {
                $total += $item->getQty();
            }
            return $total;
        });
    }

    /**
     * Retrieves all visible quote items from the session.
     *
     * @return array with instances of Mage_Sales_Model_Quote_Item
     */
    protected function getAllVisibleItems()
    {
        if ($this->helper->isAdmin()) {
            $quote = Mage::getSingleton('adminhtml/session_quote')->getQuote();
        } elseif (Mage::app()->getRequest()->getRouteName() == 'checkout') {
            // Load the queue if we are in the checkout because otherwise the call to getQuote() will cause an
            // infinite loop if the currency is switched
            // @see https://github.com/customgento/CustomGento_ConfigurableTierPrices/issues/24
            $quoteId = Mage::getSingleton('checkout/session')->getQuoteId();
            $quote   = Mage::getModel('sales/quote')->load($quoteId);
        } else {
            $quote = Mage::getSingleton('checkout/session')->getQuote();
        }

        return $quote->getAllVisibleItems();
    }
}

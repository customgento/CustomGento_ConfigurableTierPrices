Spranks_ConfigurableTierPrices
==============================

This [Magento](https://www.magentocommerce.com) module changes the way Magento calculates tier prices of configurable products. You can now add different variants of a configurable product to the cart and you will get the tier price for the total quantity of all variants in the cart.

Example
-------
There is a configurable product "football" and there are two corresponding variants "white" and "orange". The price for each football is 20 EUR. If you buy five or more, you only have to pay 18 EUR each. Now you add three white and two orange footballs to your cart. What would you expect? You would like to have the footballs for 18 EUR each, right? Not with Magento. Unfortunately, Magento will charge you 20 EUR each. Fortunately, you can install the module Spranks_ConfigurableTierPrices and 18 EUR will be charged as expected.

Requirements
------------
The module has been tested with Magento 1.4.2, 1.5.1 and 1.6.2. If you have installed Spranks_ConfigurableTierPrices before, please delete the following files and folders from your Magento root before you install this extension:

* app/etc/modules/Spranks_ConfigurableTierPrices.xml
* app/code/local/Spranks/ConfigurableTierPrices


Changelog
---------
0.0.2

* changed code pool from local to community
* FIXED wrong price if no tier price is defined
* FIXED wrong price if a special price is defined

0.0.1

* initial release on [www.coderblog.de](http://www.coderblog.de/magento-tier-prices-for-configurable-products)

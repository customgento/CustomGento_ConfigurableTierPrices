CustomGento_ConfigurableTierPrices Extension
========================================
[![Build Status](https://travis-ci.org/customgento/CustomGento_ConfigurableTierPrices.svg?branch=master)](https://travis-ci.org//CustomGento_ConfigurableTierPrices)

This extension changes the way Magento calculates tier prices of configurable products. You can now add different variants of a configurable product to the cart and you will get the tier price for the total quantity of all variants in the cart.

This extension is free of charge. However, since the development and support takes some time, I kindly ask you to donate:

[![PayPal Donate Button](https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=PLZAWC5QXVYN6)

I would also be very thankful if you could leave a review on [Magento Connect](http://www.magentocommerce.com/magento-connect/customgento-configurabletierprices.html).

Facts
-----
- version: 2.1.0
- extension key: CustomGento_ConfigurableTierPrices
- [extension on Magento Connect](http://www.magentocommerce.com/magento-connect/customgento-configurabletierprices.html)
- Magento Connect 1.0 extension key: magento-community/CustomGento_ConfigurableTierPrices
- Magento Connect 2.0 extension key: http://connect20.magentocommerce.com/community/CustomGento_ConfigurableTierPrices
- [extension on GitHub](https://github.com/customgento/CustomGento_ConfigurableTierPrices)
- [direct download link](https://github.com/customgento/CustomGento_ConfigurableTierPrices/archive/master.zip)

Description
-----------
This Magento module changes the way Magento calculates tier prices of configurable products. You can now add different variants of a configurable product to the cart and you will get the tier price for the total quantity of all variants in the cart.  
Example: There is a configurable product "football" and there are two corresponding variants "white" and "orange". The price for each football is 20 EUR. If you buy five or more, you only have to pay 18 EUR each. Now you add three white and two orange footballs to your cart. What would you expect? You would like to have the footballs for 18 EUR each, right? Not with Magento. Unfortunately, Magento will charge you 20 EUR each. Fortunately, you can install the module CustomGento_ConfigurableTierPrices and 18 EUR will be charged as expected.

Requirements
------------
- PHP >= 5.2.0
- Mage_Catalog
- Mage_Checkout
- Mage_Core
- Mage_Sales

Compatibility
-------------
- Magento >= 1.7
- Magento < 1.7: If you still use Magento < 1.7, which is not recommended at all, use version 1.0.1.

Installation Instructions
-------------------------
1. If you have installed CustomGento_ConfigurableTierPrices before, please delete the following files and folders from your Magento root before you install this extension:
  * app/etc/modules/CustomGento_ConfigurableTierPrices.xml
  * app/code/local/CustomGento/ConfigurableTierPrices
2. Install the extension via Magento Connect with the key shown above or copy all the files into your document root.
3. Clear the cache.

FAQ
---
1. I installed the extension, but it does not work - can you help me?  
Please check the following:
  * Do you use the latest version of the extension? If so, make sure you also use Magento >= 1.7.
  * Do you use Magento < 1.7? Then make sure to use [version 1.0.1 of this extension](https://github.com//CustomGento_ConfigurableTierPrices/releases/tag/v1.0.1).
  * Do you really use configurable products? This extension only works with configurable products. It does not work if you use e.g. simple products with custom options.
  * Make sure that the extension is not deactivated completely, for a specific category or for a specific product. You can check that under System - Configuration - CustomGento Configurable Tier Prices - General Settings or in the product respecively.
  * Make sure that your tier prices are lower than the normal prices. That is the way they are supposed to be used.

Uninstallation
--------------
1. Remove all extension files from your Magento installation or uninstall the extension via Magento Connect.
2. Run the following SQL query after removing the extension files:

```sql
DELETE FROM `eav_attribute` WHERE attribute_code = 'configtierprices_disabled';
DELETE FROM `core_resource` WHERE code = 'customgento_configurabletierprices_setup';
```

Support
-------
If you have any issues with this extension, open an issue on [GitHub](https://github.com/customgento/CustomGento_ConfigurableTierPrices/issues).

Contribution
------------
Any contribution is highly appreciated. The best way to contribute code is to open a [pull request on GitHub](https://help.github.com/articles/using-pull-requests).

Developer
---------
Simon Sprankel  
[http://www.customgento.com](http://www.customgento.com)  
[@SimonSprankel](https://twitter.com/SimonSprankel)

Licence
-------
[OSL - Open Software Licence 3.0](http://opensource.org/licenses/osl-3.0.php)

Copyright
---------
(c) 2012-2015 Simon Sprankel

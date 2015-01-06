Spranks_ConfigurableTierPrices Extension
========================================
[![Build Status](https://travis-ci.org/sprankhub/Spranks_ConfigurableTierPrices.svg?branch=master)](https://travis-ci.org/sprankhub/Spranks_ConfigurableTierPrices)

This extension changes the way Magento calculates tier prices of configurable products. You can now add different variants of a configurable product to the cart and you will get the tier price for the total quantity of all variants in the cart.

Facts
-----
- version: 2.1.0
- extension key: Spranks_ConfigurableTierPrices
- [extension on Magento Connect](http://www.magentocommerce.com/magento-connect/spranks-configurabletierprices-1424.html)
- Magento Connect 1.0 extension key: magento-community/Spranks_ConfigurableTierPrices
- Magento Connect 2.0 extension key: http://connect20.magentocommerce.com/community/Spranks_ConfigurableTierPrices
- [extension on GitHub](https://github.com/sprankhub/Spranks_ConfigurableTierPrices)
- [direct download link](https://github.com/sprankhub/Spranks_ConfigurableTierPrices/archive/master.zip)

Description
-----------
This Magento module changes the way Magento calculates tier prices of configurable products. You can now add different variants of a configurable product to the cart and you will get the tier price for the total quantity of all variants in the cart.  
Example: There is a configurable product "football" and there are two corresponding variants "white" and "orange". The price for each football is 20 EUR. If you buy five or more, you only have to pay 18 EUR each. Now you add three white and two orange footballs to your cart. What would you expect? You would like to have the footballs for 18 EUR each, right? Not with Magento. Unfortunately, Magento will charge you 20 EUR each. Fortunately, you can install the module Spranks_ConfigurableTierPrices and 18 EUR will be charged as expected.

Requirements
------------
- PHP >= 5.2.0
- Mage_Catalog
- Mage_Core
- Mage_Sales

Compatibility
-------------
- Magento >= 1.7
- Magento < 1.7: If you still use Magento < 1.7, which is not recommended at all, use version 1.0.1.

Installation Instructions
-------------------------
1. If you have installed Spranks_ConfigurableTierPrices before, please delete the following files and folders from your Magento root before you install this extension:
  * app/etc/modules/Spranks_ConfigurableTierPrices.xml
  * app/code/local/Spranks/ConfigurableTierPrices
2. Install the extension via Magento Connect with the key shown above or copy all the files into your document root.
3. Clear the cache.

Uninstallation
--------------
1. Remove all extension files from your Magento installation or uninstall the extension via Magento Connect.
2. Run the following SQL query after removing the extension files:

```sql
DELETE FROM `eav_attribute` WHERE attribute_code = 'configtierprices_disabled';
DELETE FROM `core_resource` WHERE code = 'spranks_configurabletierprices_setup';
```

Support
-------
If you have any issues with this extension, open an issue on [GitHub](https://github.com/sprankhub/Spranks_ConfigurableTierPrices/issues).

Contribution
------------
Any contribution is highly appreciated. The best way to contribute code is to open a [pull request on GitHub](https://help.github.com/articles/using-pull-requests).

Developer
---------
Simon Sprankel  
[http://www.simonsprankel.com](http://www.simonsprankel.com)  
[@SimonSprankel](https://twitter.com/SimonSprankel)

Licence
-------
[OSL - Open Software Licence 3.0](http://opensource.org/licenses/osl-3.0.php)

Copyright
---------
(c) 2012-2015 Simon Sprankel

<?php
/**
 * Source model for all categories except the root category.
 */
class Spranks_ConfigurableTierPrices_Model_System_Config_Source_Category
{

    public function toOptionArray()
    {
        $collection = Mage::getResourceModel('catalog/category_collection');

        $collection->addAttributeToSelect('name')
            ->addFieldToFilter('level', array('gteq' => 1))
            ->load();

        $options = array();

        $options[] = array(
            'label' => Mage::helper('spranks_configurabletierprices')->__('-- Disable for no Category --'),
            'value' => ''
        );

        foreach ($collection as $category) {
            $label = $category->getName();
            // pad, so that categories' nesting structure is displayed correctly
            $padLength = ($category->getLevel() - 1) * 2 + strlen($label);
            $label = str_pad($label, $padLength, '-', STR_PAD_LEFT);
            $options[] = array(
               'label' => $label,
               'value' => $category->getId()
            );
        }

        return $options;
    }

}

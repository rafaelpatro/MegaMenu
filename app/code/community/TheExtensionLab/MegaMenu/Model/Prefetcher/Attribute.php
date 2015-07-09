<?php

class TheExtensionLab_MegaMenu_Model_Prefetcher_Attribute
    implements TheExtensionLab_MegaMenu_Model_Prefetcher_Interface
{
    public function prefetchData(&$directiveValues)
    {
        $collection = $this->getAttributeCollection($directiveValues['attribute_ids']);
        $attributeIdArray = $this->getAttributeIdsArrayFromCollection($collection);

        Mage::register('megamenu_attributes', $attributeIdArray);
    }

    private function getAttributeIdsArrayFromCollection($collection)
    {
        $attributeIdArray = array();

        foreach ($collection as $attribute) {
            $attributeIdArray[$attribute->getAttributeId()] = $attribute;
        }

        return $attributeIdArray;
    }

    private function getAttributeCollection(array $attributeIds)
    {
        return  Mage::getResourceModel('catalog/product_attribute_collection')
            ->addFieldToFilter('main_table.attribute_id', array('in' => $attributeIds))
            ->addVisibleFilter();
    }
}
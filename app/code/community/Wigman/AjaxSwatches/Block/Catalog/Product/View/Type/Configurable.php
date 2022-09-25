<?php
/**
 * Catalog super product configurable part block
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author     Magento Core Team <core@magentocommerce.com>
 *
 *
 * Wigman changes: We're adding attribute sorting to the mix! See comments below.
 *
 */
class Wigman_AjaxSwatches_Block_Catalog_Product_View_Type_Configurable extends Wigman_AjaxSwatches_Block_Catalog_Product_View_Type_Configurable_Abstract
{
    protected $_optionLabels = null;

    public function getJsonConfig()
    {
        // Inject collect options labels before parent's job
        $this->collectOptionLabels();

        // Then let parent do the job
        return parent::getJsonConfig();
    }

    protected function collectOptionLabels()
    {
        $store = $this->getCurrentStore();
        $currentProduct = $this->getProduct();

        /* Wigman: Let's fetch all attribute labels for this product */
        $configAttributes = Mage::getResourceModel('configurableswatches/catalog_product_attribute_super_collection')
        ->addParentProductsFilter(array($currentProduct->getId()))
        ->attachEavAttributes()
        ->setStoreId($store->getId());

        /* Wigman: and then store them into an array for reference */
        $optionLabels = array();
        foreach ($configAttributes as $attr) {
            $optionLabels += $attr->getOptionLabels();
        }

        $this->_optionLabels = $optionLabels;
    }
}

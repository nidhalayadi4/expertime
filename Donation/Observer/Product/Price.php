<?php

namespace Expertime\Donation\Observer\Product;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class Price
 * @package Expertime\Donation\Observer
 */
class Price implements ObserverInterface
{

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $product = $observer->getEvent()->getData('product');
        if ('donation' != $product->getProductType()) {
            return;
        }
        $item = $observer->getEvent()->getData('quote_item');
        $item = ($item->getParentItem() ? $item->getParentItem() : $item);
        $price = $product->getAmount();

        $item->setNoDiscount(1);
        $item->setDescription('donation product');
        $item->setCustomPrice($price);
        $item->setPrice($price);
        $item->setOriginalCustomPrice($price);
        $item->setProductType('donation');
        $item->getProduct()->setIsSuperMode(true);
    }

}

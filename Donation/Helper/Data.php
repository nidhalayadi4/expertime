<?php

namespace Expertime\Donation\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Pricing\PriceCurrencyInterface;

/**
 * Class Helper Data
 * @package Expertime\Donation\Helper
 */
class Data extends AbstractHelper
{
    const DONATION_PRODUCT_ENABLED =  'expertime_donations/product/enabled';

    /**
     * @var StoreManagerInterface
     */
    private $_storeManager;

    /**
     * @var
     */
    protected $_priceCurrency;

    /**
     * Data constructor.
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        PriceCurrencyInterface $priceCurrency
    ) {
        parent::__construct($context);

        $this->_storeManager = $storeManager;
        $this->_priceCurrency = $priceCurrency;
    }

    /**
     * get currency with format
     * @param $price
     * @param bool $includeContainer
     * @return mixed
     */
    public function getCurrencyWithFormat($price, $includeContainer = false)
    {
        return $this->_priceCurrency->format($price,$includeContainer,2);
    }

    /**
     * get round price
     * @param $price
     * @return mixed
     */
    public function getRoundedPrice($price)
    {
        return $this->_priceCurrency->round($price);
    }

    /**
     * get currency symbol
     * @return string
     */
    public function getCurrentCurrencySymbol()
    {
        return $this->_priceCurrency->getCurrencySymbol();
    }

    /**
     * check the module is enabled
     * @return int
     */
    public function isEnabled()
    {
        return (boolean) $this->scopeConfig->getValue(
            self::DONATION_PRODUCT_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }

}

<?php

namespace Expertime\Donation\Observer\Checkout;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Checkout\Model\Cart as CheckoutCart;
use Magento\Quote\Model\QuoteRepository;
use Magento\Checkout\Model\Session as CheckoutSession;
use Expertime\Donation\Api\ProductRepositoryInterface;

/**
 * Class Price
 * @package Expertime\Donation\Observer
 */
class Cart implements ObserverInterface
{
    const DONATION_CONFIG_SKU = "donation/config/sku";
    const DONATION_CONFIG_TITLE = "donation/config/title";
    /**
     * @var CheckoutCart
     */
    protected $_cart;

    /**
     * @var ProductRepositoryInterface
     */
    protected $_productRepositoryInterface;

    /**
     * @var QuoteRepository
     */
    protected $_quoteRepository;

    /**
     * @var CheckoutSession
     */
    protected $_checkoutSession;

    private $scopeConfig;

    private $productRepository;


    public function __construct(
        CheckoutCart $cart,
        QuoteRepository $quoteRepository,
        CheckoutSession $checkoutSession,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        ProductRepositoryInterface $productRepositoryInterface
    )
    {
        $this->_cart = $cart;
        $this->_checkoutSession = $checkoutSession;
        $this->_quoteRepository = $quoteRepository;
        $this->scopeConfig = $scopeConfig;
        $this->productRepository = $productRepository;
        $this->_productRepositoryInterface = $productRepositoryInterface;
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getDonationProduct()
    {
        // load donation product
        $sku = $this->getSku();
        $product = $this->productRepository->get($sku);
        return $product->getId();
    }

    public function getSku()
    {
        $sku = $this->scopeConfig->getValue(
            self::DONATION_CONFIG_SKU,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        return $sku;
    }

    public function getTitle()
    {
        $title = $this->scopeConfig->getValue(
            self::DONATION_CONFIG_TITLE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        return $title;
    }


    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $donationItem = $this->getDonationProduct();

        /*if (!count($donationItems)) {
            return;
        }*/

        $checkoutSessionDonations = [];
        $quoteId = $this->_cart->getQuote()->getId();
        $quoteRepository =  $this->_quoteRepository->getActive($quoteId);
        $quoteItems = $quoteRepository->getAllVisibleItems();

        foreach($quoteItems as $quoteItem) {
            if ($quoteItem->getProduct()->getId() == $donationItem) {
                $quoteItem->getProduct()->setName($this->getTitle());

                if (!in_array($donationItem, $checkoutSessionDonations)) {
                    $checkoutSessionDonations[] = $donationItem;
                }
            }
        }

        $this->_checkoutSession->setDonationProductIds($checkoutSessionDonations);
    }

}

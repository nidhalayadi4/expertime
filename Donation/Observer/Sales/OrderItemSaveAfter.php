<?php

namespace Expertime\Donation\Observer\Sales;

use Expertime\Donation\Model\DonationsFactory;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Model\Order;

class OrderItemSaveAfter implements ObserverInterface
{

    const DONATION_CONFIG_SKU = "donation/config/sku";
    const DONATION_CONFIG_TITLE = "donation/config/title";
    const DONATION_CONFIG_DESCRIPTION = "donation/config/description";
    /**
     * @var DonationsFactory
     */
    private $donationsModel;

    /**
     * @var Order
     */
    private $order;

    private $scopeConfig;

    private $productRepository;

    /**
     * OrderPlaceAfter constructor.
     * @param DonationsFactory $donations
     * @param Order $order
     * @internal param DonationsRepository $donations
     */
    public function __construct(
        DonationsFactory $donations,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        Order $order
    ) {
        $this->donationsModel = $donations;
        $this->order = $order;
        $this->scopeConfig = $scopeConfig;
        $this->productRepository = $productRepository;
    }
    /**
     * Execute observer
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(
        Observer $observer
    ) {
        die;
        /** @var Order $order */
        $event = $observer->getEvent();
        /** @var \Magento\Sales\Model\Order\Item $orderItem */
        $orderItem = $event->getItem();

        $donationProduct = $this->getProduct();

        if ($orderItem->getProductId() != $donationProduct->getId()) {
            return;
        }

        /** @var \Expertime\Donation\Model\Donations $donation */
        $donation = $this->donationsModel->create();

        $orderId = $orderItem->getOrderId();
        $order = $this->order->load($orderId);

        $donation->setTitle($this->getTitle());
        $donation->setSku($this->getSku());
        $donation->setAmount($donationProduct->getPrice());
        $donation->setOrderId($orderId);
        $donation->setDescription($this->getDescription());
        $donation->setCreatedAt($orderItem->getCreatedAt());
        $donation->save();
    }

    public function getProduct()
    {
        $sku = $this->getSku();
        $product = $this->productRepository->get($sku);
        return $product;
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

    public function getDescription()
    {
        $description = $this->scopeConfig->getValue(
            self::DONATION_CONFIG_DESCRIPTION,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        return $description;
    }
}

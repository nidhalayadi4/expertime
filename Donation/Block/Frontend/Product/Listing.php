<?php

namespace Expertime\Donation\Block\Frontend\Product;

use Expertime\Donation\Api\ProductRepositoryInterface;
use Expertime\Donation\Helper\Data as DonationHelper;
use Magento\Catalog\Block\Product\ImageBuilder;
use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Model\ResourceModel\Product as ProductResource;
use Magento\Checkout\Helper\Cart as CartHelper;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class ListProduct
 * @package Expertime\Donation\Block
 */
class Listing extends \Magento\Framework\View\Element\Template
{
    const DONATION_CONFIG_ENABLE = "donation/config/enable";
    const DONATION_CONFIG_SKU = "donation/config/sku";
    const DONATION_CONFIG_TITLE = "donation/config/title";
    const DONATION_CONFIG_DESCRIPTION = "donation/config/description";
    const DONATION_CONFIG_AMOUNT = "donation/config/amount";
    /**
     * @var CartHelper
     */
    protected $cartHelper;

    /**
     * @var ImageBuilder
     */
    private $imageBuilder;

    /**
     * @var DonationHelper
     */
    protected $donationHelper;

    /**
     * @var ProductFactory
     */
    protected $productFactory;

    /**
     * @var ProductResource
     */
    protected $productResource;

    /**
     * @var CheckoutSession
     */
    protected $_checkoutSession;

    /**
     * @var array
     */
    protected static $_productModels = [];

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepositoryInterface;

    private $scopeConfig;

    private $productRepository;

    public function __construct(
        DonationHelper $donationHelper,
        ProductFactory $productFactory,
        ProductResource $productResource,
        CheckoutSession $checkoutSession,
        ProductRepositoryInterface $productRepositoryInterface,
        Context $context,
        CartHelper $cartHelper,
        ImageBuilder $imageBuilder,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        array $data = []
    ) {
        $this->cartHelper = $cartHelper;
        $this->imageBuilder = $imageBuilder;
        $this->donationHelper = $donationHelper;
        $this->productFactory = $productFactory;
        $this->productResource = $productResource;
        $this->_checkoutSession = $checkoutSession;
        $this->productRepositoryInterface = $productRepositoryInterface;
        $this->scopeConfig = $scopeConfig;
        $this->productRepository = $productRepository;

        parent::__construct(
            $context,
            $data
        );
    }

    /**
     * enabled ajax request default
     * @return bool
     */
    public function isAjax()
    {
        return true;
    }

    /**
     * get donation helper class
     * @return DonationHelper
     */
    public function getHelper()
    {
        return $this->donationHelper;
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getProductCollection()
    {
        // load donation product list
        return $this->productRepositoryInterface->getList();
    }

    /**
     * @return mixed
     */
    public function getDonationProductIds()
    {
        return $this->_checkoutSession->getDonationProductIds();
    }


    /**
     * @param $productId
     * @param bool $isDeleted
     * @param array $additional
     * @return string
     */
    public function getAddToCartUrl($productId, $isDeleted = false, $additional = [])
    {
        $route = 'donation/cart/' . ($isDeleted ? 'delete' : 'add');

        if ($this->isAjax()) {
            return $this->getUrl($route, ['product' => $productId]);
        }
        $product = $this->getProduct($productId);
        return $this->cartHelper->getAddUrl($product, $additional);
    }

    /**
     * @param $productId
     * @param $imageId
     * @return string
     */
    public function getProductImageUrl($productId, $imageId)
    {
        $product = $this->getProduct($productId);
        return $this->getImage($product, $imageId);
    }

    /**
     * Retrieve product image
     *
     * @param \Magento\Catalog\Model\Product $product
     * @param string $imageId
     * @param array $attributes
     * @return \Magento\Catalog\Block\Product\Image
     */
    public function getImage($product, $imageId, $attributes = [])
    {
        return $this->imageBuilder->setProduct($product)
            ->setImageId($imageId)
            ->setAttributes($attributes)
            ->create();
    }

    /**
     * Get quote object associated with cart. By default it is current customer session quote
     *
     * @return \Magento\Quote\Model\Quote
     */
    public function getQuoteData()
    {
        $this->_checkoutSession->getQuote();
        if (!$this->hasData('quote')) {
            $this->setData('quote', $this->_checkoutSession->getQuote());
        }
        return $this->_getData('quote');
    }

    public function isActive()
    {
        $active = $this->scopeConfig->getValue(
            self::DONATION_CONFIG_ENABLE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        return $active;
    }

    public function getProductImage()
    {
        $objectManager =\Magento\Framework\App\ObjectManager::getInstance();
        $helperImport = $objectManager->get('\Magento\Catalog\Helper\Image');
        $product = $this->getProduct();

        $imageUrl = $helperImport->init($product, 'product_page_image_small')
            ->setImageFile($product->getSmallImage()) // image,small_image,thumbnail
            ->resize(380)
            ->getUrl();
        return $imageUrl;
    }

    public function getProduct()
    {
        $sku = $this->getSku();
        $product = $this->productRepository->get($sku);
        return $product;
    }

    public function getProductId()
    {
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

    public function getDescription()
    {
        $description = $this->scopeConfig->getValue(
            self::DONATION_CONFIG_DESCRIPTION,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        return $description;
    }

    public function getAmount()
    {
        $amount = $this->scopeConfig->getValue(
            self::DONATION_CONFIG_AMOUNT,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        return $amount;
    }
}

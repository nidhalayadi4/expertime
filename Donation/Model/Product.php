<?php

namespace Expertime\Donation\Model;

use Magento\Framework\Model\AbstractModel;
use Expertime\Donation\Api\Data\ProductInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Expertime\Donation\Model\ResourceModel\Product as ResourceModel;

/**
 * Class Donations
 * @package Expertime\Donation\Model
 */
class Product extends AbstractModel implements ProductInterface, IdentityInterface
{
    const CACHE_TAG = 'expertime_donation_product';

    protected $_cacheTag = 'expertime_donation_product';

    protected $_eventPrefix = 'expertime_donation_product';

    /**
     * @return void
     */
    public function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * set entity id
     * @return int|null
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * get product sku
     * @return string|null
     */
    public function getSku()
    {
        return $this->getData(self::SKU);
    }

    /**
     * get product amount
     * @return float|null
     */
    public function getAmount()
    {
        return $this->getData(self::AMOUNT);
    }

    /**
     * get product title
     * @return string|null
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * get product id
     * @return int|null
     */
    public function getProductId()
    {
        return $this->getData(self::PRODUCT_ID);
    }

    /**
     * get product description
     * @return string|null
     */
    public function getDescription()
    {
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * get product store ids
     * @return array|null
     */
    public function getStoreIds()
    {
        return $this->getData(self::STORE_IDS);
    }

    /**
     * get product create time
     * @return datetime|string|null
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * get identifie tag
     * @return string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * set entity id
     * @param int|mixed $id
     * @return ProductInterface|Product
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * set product sku
     * @param string $sku
     * @return ProductInterface|Product
     */
    public function setSku($sku)
    {
        return $this->setData(self::SKU, $sku);
    }

    /**
     * set product title
     * @param string $title
     * @return ProductInterface|Product
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * set product amount
     * @param float $amount
     * @return ProductInterface|Product
     */
    public function setAmount($amount)
    {
        return $this->setData(self::AMOUNT, $amount);
    }

    /**
     * set product description
     * @param string $contente
     * @return ProductInterface|Product
     */
    public function setDescription($contente)
    {
        return $this->setData(self::DESCRIPTION, $contente);
    }

    /**
     * set product id
     * @param int $id
     * @return ProductInterface|Product
     */
    public function setProductId($id)
    {
        return $this->setData(self::PRODUCT_ID, $id);
    }

    /** set product store ids
     * @param string $storeIds
     * @return ProductInterface|Product
     */
    public function setStoreIds($storeIds)
    {
        return $this->setData(self::STORE_IDS, $storeIds);
    }

    /**
     * set product create time
     * @param string $createdAt
     * @return ProductInterface|Product
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

}

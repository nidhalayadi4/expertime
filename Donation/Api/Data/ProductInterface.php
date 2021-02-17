<?php


namespace Expertime\Donation\Api\Data;

/**
 * Interface ProductInterface
 * @package Expertime\Donation\Api\Data
 */
interface ProductInterface
{
    const ID = 'entity_id';
    const SKU = 'sku';
    const TITLE = 'title';
    const AMOUNT = 'amount';
    const STORE_IDS = 'store_ids';
    const PRODUCT_ID = 'product_id';
    const DESCRIPTION = 'description';
    const CREATED_AT = 'created_at';

    /**
     * Get Entity ID
     * @return integer|null
     */
    public function getId();

    /**
     * Get sku
     * @return string|null
     */
    public function getSku();

    /**
     * Get amount
     * @return float|null
     */
    public function getAmount();

    /**
     * Get title
     * @return string|null
     */
    public function getTitle();

    /**
     * Get product id
     * @return integer|null
     */
    public function getProductId();

    /**
     * @param string $storeIds
     * @return \Expertime\Donation\Api\Data\ProductInterface
     */
    public function getStoreIds();

    /**
     * Get description
     * @return string|null
     */
    public function getDescription();

    /**
     * Get created_at
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set Entity ID
     * @param integer $id
     * @return \Expertime\Donation\Api\Data\ProductInterface
     */
    public function setId($id);

    /**
     * Set Entity ID
     * @param integer $id
     * @return \Expertime\Donation\Api\Data\ProductInterface
     */
    public function setProductId($id);

    /**
     * @param string $storeIds
     * @return \Expertime\Donation\Api\Data\ProductInterface
     */
    public function setStoreIds($storeIds);

    /**
     * Set sku
     * @param integer $sku
     * @return \Expertime\Donation\Api\Data\ProductInterface
     */
    public function setSku($sku);

    /**
     * Set amount
     * @param float $amount
     * @return \Expertime\Donation\Api\Data\ProductInterface
     */
    public function setAmount($amount);

    /**
     * Set title
     * @param string $title
     * @return \Expertime\Donation\Api\Data\ProductInterface
     */
    public function setTitle($title);

    /**
     * Set description
     * @param string $contente
     * @return \Expertime\Donation\Api\Data\ProductInterface
     */
    public function setDescription($contente);

    /**
     * Set created_at
     * @param string $createdAt
     * @return \Expertime\Donation\Api\Data\ProductInterface
     */
    public function setCreatedAt($createdAt);

}

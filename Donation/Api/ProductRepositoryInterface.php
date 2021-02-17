<?php

namespace Expertime\Donation\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Expertime\Donation\Api\Data\ProductInterface;

/**
 * Interface DonationsRepositoryInterface
 * @package Expertime\Donation\Api
 */
interface ProductRepositoryInterface
{

    /**
     * Save Donations
     * @param ProductInterface $products
     * @return ProductInterface
     * @throws LocalizedException
     */
    public function save(ProductInterface $products);

    /**
     * Retrieve Donations
     * @param string $id
     * @return ProductInterface
     * @throws LocalizedException
     */
    public function getById($id);

    /**
     * Retrieve Donations product list
     * @throws LocalizedException
     * @return array
     */
    public function getList();

    /**
     * Delete Donations
     * @param ProductInterface $product
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(ProductInterface $product);

    /**
     * Delete Donations by ID
     * @param string $id
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById($id);
}

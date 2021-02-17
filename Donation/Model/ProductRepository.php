<?php

namespace Expertime\Donation\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;

use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

use Expertime\Donation\Api\Data\ProductInterface;
use Expertime\Donation\Api\ProductRepositoryInterface;
use Expertime\Donation\Model\ResourceModel\Product as ObjectResourceModel;
use Expertime\Donation\Model\ResourceModel\Product\CollectionFactory;

/**
 * Class ProductRepository
 * @package Expertime\Donation\Model
 */
class ProductRepository implements ProductRepositoryInterface
{
    /**
     * @var ProductFactory
     */
    protected $objectFactory;

    /**
     * @var ObjectResourceModel
     */
    protected $objectResourceModel;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var SearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * ProductRepository constructor.
     * @param ProductFactory $objectFactory
     * @param ObjectResourceModel $objectResourceModel
     * @param CollectionFactory $collectionFactory
     * @param SearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        ProductFactory $objectFactory,
        ObjectResourceModel $objectResourceModel,
        CollectionFactory $collectionFactory,
        SearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->objectFactory        = $objectFactory;
        $this->objectResourceModel  = $objectResourceModel;
        $this->collectionFactory    = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * @param ProductInterface $product
     * @return ProductInterface
     * @throws CouldNotSaveException
     */
    public function save(ProductInterface $product)
    {
        try {
            $this->objectResourceModel->save($product);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the donations: %1',
                $exception->getMessage()
            ));
        }
        return $product;
    }

    /**
     * @param ProductInterface $product
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(ProductInterface $product)
    {
        try {
            $this->objectResourceModel->delete($product);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Donations: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @param string $id
     * @return bool
     * @throws CouldNotDeleteException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($id)
    {
        return $this->delete($this->getById($id));
    }

    /**
     * @param string $id
     * @return ProductInterface
     * @throws NoSuchEntityException
     */
    public function getById($id)
    {
        $product = $this->objectFactory->create();
        $product->getResource()->load($product, $id);
        if (!$product->getId()) {
            throw new NoSuchEntityException(__('Product with id "%1" does not exist.', $id));
        }
        return $product;
    }

    /**
     * Retrieve Donations product list
     * @return array
     */
    public function getList()
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToSelect(['sku', 'amount', 'title', 'product_id', 'description'])
            ->setPageSize(10)
            ->setOrder(ProductInterface::CREATED_AT, 'desc');

        return $collection->getItems();
    }
}

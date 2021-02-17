<?php

declare(strict_types=1);

namespace Expertime\Donation\Model\Product;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Expertime\Donation\Model\ResourceModel\Product\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
    /**
     * DataProvider constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param array $meta
     * @param array $data
     * @param \Expertime\Donation\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        array $meta = [],
        array $data = [],
        CollectionFactory $productCollectionFactory
    ) {
        $this->collection = $productCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        $this->loadedData = array();
        /** @var Product $product */
        foreach ($items as $product) {
            $this->loadedData[$product->getId()]['product'] = $product->getData();
        }

        return $this->loadedData;
    }
}

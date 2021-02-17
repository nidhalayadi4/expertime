<?php

namespace Expertime\Donation\Model\ResourceModel\Donations;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init(
            'Expertime\Donation\Model\Donation',
            'Expertime\Donation\Model\ResourceModel\Donation'
        );
    }
}

<?php

namespace Expertime\Donation\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Class Donations
 * @package Expertime\Donation\Model
 */
class Donation extends AbstractModel
{
    /**
     * @return void
     */
    public function _construct()
    {
        $this->_init('Expertime\Donation\Model\ResourceModel\Donations');
    }

    /**
     * Get donations_id
     * @return string
     */
    public function getDonationsId()
    {
        return $this->getData("entity_id");
    }


    public function setDonationsId($donationsId)
    {
        return $this->setData("entity_id", $donationsId);
    }

    /**
     * Get name
     * @return string
     */
    public function getName()
    {
        return $this->getData("title");
    }


    public function setName($name)
    {
        return $this->setData("title", $name);
    }

    /**
     * Get sku
     * @return string
     */
    public function getSku()
    {
        return $this->getData("sku");
    }

    public function setSku($sku)
    {
        return $this->setData("sku", $sku);
    }

    /**
     * Get amount
     * @return string
     */
    public function getAmount()
    {
        return $this->getData("amount");
    }

    public function setAmount($amount)
    {
        return $this->setData("amount", $amount);
    }

    /**
     * Get order_id
     * @return string
     */
    public function getOrderId()
    {
        return $this->getData("order_id");
    }


    public function setOrderId($order_id)
    {
        return $this->setData("order_id", $order_id);
    }

    /**
     * Get created_at
     * @return string|null
     */
    public function getCreatedAt()
    {
        return $this->getData("created_at");
    }


    public function setCreatedAt($createdAt)
    {
        return $this->setData("created_at", $createdAt);
    }
}

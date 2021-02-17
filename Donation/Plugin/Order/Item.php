<?php

namespace Expertime\Donation\Plugin\Order;

use Magento\Framework\Serialize\Serializer\Json;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Quote\Model\Quote\Item\ToOrderItem as QuoteToOrderItem;

class Item
{
    /**
     * @var Json|mixed
     */
    protected $_serializer;

    /**
     * @var CheckoutSession
     */
    protected $_checkoutSession;

    public function __construct(Json $serializer, CheckoutSession $checkoutSession)
    {
        $this->_serializer = $serializer;
        $this->_checkoutSession = $checkoutSession;
    }

    /**
     * @param QuoteToOrderItem $subject
     * @param \Closure $proceed
     * @param $item
     * @param array $data
     * @return mixed
     */
    public function aroundConvert(QuoteToOrderItem $subject,
                                  \Closure $proceed,
                                  $item,
                                  $data = []
    ) {

        $orderItem = $proceed($item, $data);

//        $donationProductIds = $this->_checkoutSession->getDonationProductIds();
//
//        $customAdditionalOptions = ['product_type' => 'donation'];
//
//        if ($customAdditionalOptions) {
//            // Get Order Item's other options
//            $options = $orderItem->getProductOptions();
//            // Set additional options to Order Item
//            $options['additional_options'] = $customAdditionalOptions;
//            $orderItem->setProductOptions($options);
//        }

        return $orderItem;
    }

}

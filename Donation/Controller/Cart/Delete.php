<?php

namespace Expertime\Donation\Controller\Cart;

/**
 * Action Delete.
 *
 * Deletes item from cart.
 */
class Delete extends \Magento\Checkout\Controller\Cart\Delete
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;
    /**
     * @var \Magento\Framework\Json\Helper\Data
     */
    protected $jsonHelper;

    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator
     */
    protected $formKeyValidator;

    /**
     * Delete constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param \Magento\Checkout\Model\Cart $cart
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Framework\Json\Helper\Data $jsonHelper
    ) {
        parent::__construct(
            $context,
            $scopeConfig,
            $checkoutSession,
            $storeManager,
            $formKeyValidator,
            $cart
        );
        $this->productRepository = $productRepository;
        $this->jsonHelper = $jsonHelper;
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface|\Magento\Framework\Controller\Result\Redirect
     */
    public function execute() : \Magento\Framework\Controller\Result\Redirect
    {
        $result = [];

        if (!$this->_formKeyValidator->validate($this->getRequest())) {
            $result['error'] = __('Your session has expired');
            return $this->jsonResponse($result);
        }

        $id = (int)$this->getRequest()->getParam('product');

        if (!$id) {
            $result['error'] =  __('Donation removed failure.');
            return $this->jsonResponse($result);
        }
        $product = $this->productRepository->getById($id);
        $item = $this->cart->getQuote()->getItemByProduct($product);

        try {
            $this->cart->removeItem($item->getItemId());
            // We should set Totals to be recollected once more because of Cart model as usually is loading
            // before action executing and in case when triggerRecollect setted as true recollecting will
            // executed and the flag will be true already.
            $this->cart->getQuote()->setTotalsCollectedFlag(false);
            $this->cart->save();
            $result['success'] = __(
                'Donation removed success.'
            );
         } catch (\Exception $e) {
            $result['error'] =  __('Donation removed failure.');
            $this->_objectManager->get(\Psr\Log\LoggerInterface::class)->critical($e);
        }

        return $this->jsonResponse($result);
    }

    /**
     * Create json response
     *
     * @return \Magento\Framework\Controller\ResultInterface|\Magento\Framework\Controller\Result\Redirect
     */
    public function jsonResponse($response = '')
    {
        return $this->getResponse()->representJson(
            $this->jsonHelper->jsonEncode($response)
        );
    }
}

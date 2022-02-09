<?php

namespace Kkaffa\ProductView\Block\Adminhtml\Product;

use Magento\Catalog\Block\Adminhtml\Product\Edit\Button\Generic;
use Magento\Catalog\Model\Product;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\Context;
use Magento\Store\Model\App\Emulation;
use function xsarus\ProductView\Block\Adminhtml\Product\__;

class ViewProduct extends Generic
{
    protected RequestInterface $_request;
    protected Product $_product;
    protected Emulation $_emulation;
    protected UrlInterface $_url;

    /**
     * @param RequestInterface $_request
     * @param Product $_product
     * @param Emulation $_emulation
     * @param UrlInterface $_url
     * @param Context $context
     * @param Registry $registry
     */
    public function __construct(
        RequestInterface $_request,
        Product          $_product,
        Emulation        $_emulation,
        UrlInterface     $_url,
        Context          $context,
        Registry         $registry
    )
    {
        $this->_request = $_request;
        $this->_product = $_product;
        $this->_emulation = $_emulation;
        $this->_url = $_url;
        parent::__construct($context, $registry);
    }


    /**
     * @return array
     */
    public function getButtonData(): array
    {
        $this->getProductUrl();
        if ($this->checkRequestAction()) {
            return [
                'label' => __('View Product'),
                'class' => 'action-secondary',
                'on_click' => $this->determineUrl(),
                'sort_order' => 1
            ];
        } else {
            return [];
        }
    }

    protected function checkRequestAction(): bool
    {
        return $this->_request->getActionName() === 'edit';
    }

    protected function determineUrl(): string
    {
        if ($this->getProduct() && $this->getProduct()->getUrlKey()) {
            return sprintf("window.open('%s', '_blank')", $this->getProductUrl());
        } else {
            return "window.alert('" . __('Current product doens\'t have a URL Key') . "')";
        }
    }

    protected function getProductUrl(): string
    {
        return $this->registry->registry('current_store')->getBaseUrl() . $this->getProduct()->getUrlKey() . '.html';
    }

}

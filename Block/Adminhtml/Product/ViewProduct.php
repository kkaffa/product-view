<?php

namespace Kkaffa\ProductView\Block\Adminhtml\Product;

use Magento\Catalog\Block\Adminhtml\Product\Edit\Button\Generic;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\UiComponent\Context;

class ViewProduct extends Generic
{
    protected RequestInterface $_request;

    /**
     * @param RequestInterface $_request
     * @param Context $context
     * @param Registry $registry
     */
    public function __construct(
        RequestInterface $_request,
        Context          $context,
        Registry         $registry
    )
    {
        $this->_request = $_request;
        parent::__construct($context, $registry);
    }


    /**
     * @return array
     */
    public function getButtonData(): array
    {
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

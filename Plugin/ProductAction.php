<?php

namespace Kkaffa\ProductView\Plugin;

use Magento\Catalog\UI\Component\Listing\Columns\ProductActions;
use Magento\Framework\UrlInterface;

class ProductAction
{
    protected UrlInterface $_urlBuilder;

    /**
     * @param UrlInterface $_urlBuilder
     */
    public function __construct(UrlInterface $_urlBuilder)
    {
        $this->_urlBuilder = $_urlBuilder;
    }

    /**
     * Add view product option to datasource
     * @param ProductActions $productActions
     * @param array $dataSource
     * @return array
     */
    public function afterPrepareDataSource(
        ProductActions $productActions,
        array $dataSource
    ): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $item[$productActions->getData('name')]['preview'] = [
                    'href' => $this->getProductUrl($item),
                    'label' => __('View Product'),
                    'target' => '_blank',
                    'hidden' => false
                ];
            }
        }

        return $dataSource;
    }

    /**
     * Return the product url of the given product
     *
     * @param $product
     * @return string
     */
    public function getProductUrl($product): string
    {
        return $this->_urlBuilder->getBaseUrl() . $product['url_key'] . '.html';
    }


}
